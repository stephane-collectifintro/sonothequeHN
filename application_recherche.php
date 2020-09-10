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
WHERE nom_artiste LIKE '%".$search."%' OR chanson.nom LIKE '%".$search."%' OR album.titre LIKE '%".$search."%'
ORDER BY nom_artiste,album.titre,piste ASC");		
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
		    //$id = $res->id_artiste;
			$nom = stripslashes(utf8_encode($res->nom_artiste));
			$nom = str_replace ( "&" , "et" , $nom ); 
			//$nom_album = stripslashes(utf8_encode($res->titre));
			//$nom_chanson = stripslashes(utf8_encode($res->nom));
			//$nom_chanson = str_replace ( "&" , "et" , $nom_chanson ); 
			
			if(empty($nom)){
				$nom = "inconnu";
				?>
				<evenement nom_artiste="<?php echo $nom;  ?>" />
            	<?php  
			}else{ 
				 ?>
				 <evenement nom_artiste="<?php echo $nom;  ?>"/>
				<?php
			}
	 }
?>
<?php echo '</programmation>'; ?>