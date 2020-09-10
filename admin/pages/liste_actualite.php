<?php

if(isset($_GET['id'])){
	
	if(file_exists($_GET['path'])){
		unlink($_GET['path']);
	}
	$champs = array('photo_actualite');
	$values = array('');
	$sql->delete('actualite','id_actualite='.$_GET['id']);		
	if($sql->execute()){
		echo "<script>window.location.href='liste_actualite.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">actualite </div>
	
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_actualite.php"><input type="button" value="Ajouter une actualite" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="4"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("actualite","titre_actualite LIKE '%".$_POST['search']."%'","*","ORDER BY date_actualite DESC");
	}else{
		$sql->select("actualite","","*","ORDER BY date_actualite DESC");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_actualite'];
		$nom = stripslashes(utf8_encode($res['titre_actualite']));
		$photo = utf8_encode($res['photo_actualite']);
		//
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
    <tr class="<?php echo $color; ?>"><td><a href="actualite-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td width="20" align="center"><a href="actualite-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_actualite-<?php echo $id; ?>.php?path=../<?php echo $photo; ?>" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>