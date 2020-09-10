<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$id_album=$_GET['id'];
	$sql = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$id_album." ORDER BY piste ASC");
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
		   $url=$_MUSIC_ROOT.$res->url_pj;
		   $id=$res->id_morceau;
		   $titre = utf8_encode($res->nom);
		   $duree = utf8_encode($res->duree);
		   $titre = str_replace ( "&" , "et" , $titre ); 
		   $titre = str_replace ( '"' , "" , $titre ); 
		 ?>
		 <evenement url="<?php echo $url; ?>" titre="<?php echo $titre;  ?>" duree="<?php echo $duree ?>" id="<?php echo $id ?>" />
<?php
	 }
?>
<?php echo '</programmation>'; ?>	