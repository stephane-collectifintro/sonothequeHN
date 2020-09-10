<?php

if(isset($_GET['id'])){

	$sql = new sql();
	$sql2 = new sql();
	//
	$sql->select("`artiste`
INNER JOIN album ON artiste.id_artiste = album.id_artiste
INNER JOIN chanson ON chanson.id_album = album.id_album
INNER JOIN portfolio_sonotheque ON chanson.id_morceau = portfolio_sonotheque.id_pj","artiste.id_artiste=".$_GET['id'],"*, album.nom_stockage AS nom_stockage_album, artiste.nom_stockage AS nom_stockage_artiste");
	//echo $sql->getQuery();
	$sql->execute();
	while($res = $sql->result()){
		$nom_stockage_artiste = $res['nom_stockage_artiste'];
		$nom_stockage_album = $res['nom_stockage_album'];
		//
		$sql2->select("portfolio_sonotheque",'id_pj='.$res['id_jaquette']);
		$sql2->execute();
		$res2 = $sql2->result();
		//
		if(file_exists('../musik_sonotk/'.$res2['url_pj'])){
			unlink('../musik_sonotk/'.$res2['url_pj']);
			$sql2->delete("portfolio_sonotheque","id_pj=".$res2['id_pj']);
			$sql2->execute();
		}
		if(file_exists('../musik_sonotk/'.$res['url_pj'])){
			unlink('../musik_sonotk/'.$res['url_pj']);
			$sql2->delete("portfolio_sonotheque","id_pj=".$res['id_pj']);
			$sql2->execute();
		}
		//

		rmdir('../musik_sonotk/'.$nom_stockage_artiste.'/'.$nom_stockage_album);
		$sql2->delete("album","id_album=".$res['id_album']);
		$sql2->execute();
	}

	$sql->select("artiste","id_artiste=".$_GET['id']);
	$sql->execute();
	$res = $sql->result();
	$nom_stockage_artiste = $res['nom_stockage'];

	rmdir('../musik_sonotk/'.$nom_stockage_artiste);
	$sql->delete("artiste","id_artiste=".$_GET['id']);
	$sql->execute();

}
?>
<div id="liste">
	<div class="titre">artiste</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_artiste.php"><input type="button" value="Ajouter un artiste" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="2"></td></tr>
	<?php

	$ligne = true;

	$sql = new sql();

	if($_POST['search']){
		$sql->select("artiste","nom_artiste LIKE '%".$_POST['search']."%'","*","ORDER BY nom_artiste");
	}else{
		$sql->select("artiste","","*","ORDER BY nom_artiste");
	}
	$sql->execute();
	while($res = $sql->result()){

		$id = $res['id_artiste'];
		$nom = utf8_encode($res['nom_artiste']);
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}

	?>
    <tr class="<?php echo $color; ?>"><td><a href="artiste-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td width="20" align="center"><a href="artiste-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_artiste-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>

</div>
