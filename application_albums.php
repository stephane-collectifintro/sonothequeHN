<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$id=$_GET['id'];
	$sql = $pdo->query("SELECT * FROM album INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=album.id_jaquette WHERE album.id_artiste=".$id." ORDER BY annee_sortie DESC");
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
		   $id_album = $res->id_album;
		   $nom_album = stripslashes(utf8_encode($res->titre));
		   $annee = $res->annee_sortie;
		   $jaquette = $_MUSIC_ROOT.$res->url_pj;
		   $droit = $res->gestion_droit;
		   if($droit != "Pas d'autorisation"){$droit = "ok";}
		 ?>
		 		<evenement id_album="<?php echo $id_album; ?>" nom_album="<?php echo $nom_album;  ?>" annee="<?php echo $annee;  ?>" jaquette="<?php echo $jaquette;  ?>" droit="<?php echo $droit; ?>" />
<?php
		  // }
	 }
?>
<?php echo '</programmation>'; ?>