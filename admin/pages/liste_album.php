<?php

if(isset($_GET['id'])){
	
	$sql = new sql();
	$sql2 = new sql();
	//
	$sql->select("chanson INNER JOIN album ON chanson.id_album=album.id_album INNER JOIN portfolio_sonotheque ON chanson.id_morceau=portfolio_sonotheque.id_pj","chanson.id_album=".$_GET['id']);
	$sql->execute();
	while($res = $sql->result()){
		if(file_exists('../musik_sonotk/'.$res['url_pj'])){
			unlink('../musik_sonotk/'.$res['url_pj']);
		}
		
		$sql2->delete("portfolio_sonotheque","id_pj=".$res['id_pj']);
		$sql2->execute();
	}
	$sql->delete("chanson","id_album=".$_GET['id']);
	$sql->execute();
		
	$sql->select("album INNER JOIN portfolio_sonotheque ON album.id_jaquette=portfolio_sonotheque.id_pj","album.id_album=".$_GET['id']);
	$sql->execute();
	$res = $sql->result();
	if(file_exists('../musik_sonotk/'.$res['url_pj'])){
		@unlink('../musik_sonotk/'.$res['url_pj']);
	}	
	$sql->delete("portfolio_sonotheque","id_pj=".$res['id_pj']);
	$sql->execute();
	
	
	$sql->select("album INNER JOIN artiste ON album.id_artiste=artiste.id_artiste","album.id_album=".$_GET['id'],"album.nom_stockage AS nom_stockage_album, artiste.nom_stockage AS nom_stockage_artiste");
	$sql->execute();
	$res = $sql->result();
	
	$chemin = $res['nom_stockage_artiste'].'/'.$res['nom_stockage_album'];
	
	if(file_exists('../musik_sonotk/'.$chemin)){
		$tab = glob('../musik_sonotk/'.$chemin.'/*');
		foreach($tab as $filename){
			if(file_exists($filename)){
				unlink($filename);
			}
		}	
		rmdir('../musik_sonotk/'.$chemin);
	}
	//
	
	$sql->delete("album","id_album='".$_GET['id']."'");
	
	if($sql->execute()){
		echo "<script>window.location.href='liste_album.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">album</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_album.php"><input type="button" value="Ajouter une album" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="3"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("album INNER JOIN artiste ON artiste.id_artiste=album.id_artiste","titre LIKE '%".$_POST['search']."%'","*","ORDER BY nom_artiste, titre");
	}else{
		$sql->select("album INNER JOIN artiste ON artiste.id_artiste=album.id_artiste","","*","ORDER BY nom_artiste, titre");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_album'];
		$nom = stripslashes(utf8_encode($res['titre']));
		
		$sql2 = new sql();
		$sql2->select("artiste","id_artiste=".$res['id_artiste']);
		$sql2->execute();
		$res2 = $sql2->result();
		
		$id_artiste = $res2['id_artiste'];
		$artiste=stripslashes($res2['nom_artiste']);
		
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="album-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td><em><a href="artiste-<?php echo $id_artiste; ?>.php"><?php echo utf8_encode($artiste); ?></a></em></td><td width="20" align="center"><a href="album-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_album-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>