<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$search=$_GET['recherche'];
	$sql = $pdo->query("SELECT * 
FROM artiste 
INNER JOIN album ON artiste.id_artiste = album.id_artiste
INNER JOIN chanson ON chanson.id_album = album.id_album
INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
WHERE nom_artiste LIKE '%".$search."%'
ORDER BY nom_artiste ASC");		
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
			$nom = stripslashes(utf8_encode($res->nom_artiste));
			$nom = str_replace ( "&" , "et" , $nom ); 
			$id_artiste = $res->id_artiste; 
			 ?>
			 <evenement nom_artiste="<?php echo $nom;  ?>" id_artiste="<?php echo $id_artiste;  ?>" />
			<?php
	 }
?>
<?php echo '</programmation>'; ?>