<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$search=$_GET['recherche'];
	$sql = $pdo->query("SELECT * 
FROM artiste 
INNER JOIN album ON artiste.id_artiste = album.id_artiste
INNER JOIN chanson ON chanson.id_album = album.id_album
INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
WHERE nom_artiste LIKE '%".$search."%' OR album.titre LIKE '%".$search."%' OR chanson.nom LIKE '%".$search."%'
ORDER BY nom_artiste ASC");		
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
			$id_album = $res->id_album;
			$nom_album = stripslashes(utf8_encode($res->titre));
			$nom_album = str_replace ( '"' , "'" , $nom_album );
			$nom_album = str_replace ( "&" , "et" , $nom_album );
			$jaquette = $_MUSIC_ROOT.$res->url_pj; 
			 ?>
			 <evenement nom_album="<?php echo $nom_album;  ?>" id_album="<?php echo $id_album;  ?>" jaquette="<?php echo $jaquette;  ?>" />
			<?php
	 }
?>
<?php echo '</programmation>'; ?>