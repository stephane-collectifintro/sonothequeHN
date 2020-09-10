<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$sql = $pdo->query('SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo ORDER BY nom_artiste ASC');
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
		 $id = $res->id_artiste;
		 $artiste = utf8_encode($res->nom_artiste);
		 $artiste = str_replace ( "&" , "et" , $artiste ); 
		 $artiste = str_replace ( "\'" , "'" , $artiste ); 
		 $artiste = str_replace ( "ñ" , "n" , $artiste ); 
		 $artiste = str_replace ( "Ñ" , "N" , $artiste );
		 $bio_artiste = stripslashes(utf8_encode($res->bio_artiste));
		 $bio_artiste = strip_tags($bio_artiste);
		 $bio_artiste = html_entity_decode($bio_artiste,ENT_QUOTES);
		 $bio_artiste = str_replace ( '"' , "'" , $bio_artiste );
		 $bio_artiste = str_replace ( "&" , "et" , $bio_artiste );  
		 $bio_artiste = str_replace ( "#" , "" , $bio_artiste );  
		 $bio_artiste = str_replace ( "@" , "" , $bio_artiste );  
		 $bio_artiste = str_replace ( "%" , "" , $bio_artiste ); 
		 $bio_artiste = str_replace ( "ñ" , "n" , $bio_artiste ); 
		 $bio_artiste = str_replace ( "Ñ" , "N" , $bio_artiste );
		 $bio_artiste = str_replace ( "§" , "ss" , $bio_artiste );
		 $bio_artiste = str_replace ( "$" , "" , $bio_artiste );
		 $bio_artiste = str_replace ( "À" , "A" , $bio_artiste );
		 $bio_artiste = str_replace ( "<span style='font-family: Arial, sans-ser" , "" , $bio_artiste );
		 $url_site = stripslashes(utf8_encode($res->url_site_web));
		 $url_site_2 = stripslashes(utf8_encode($res->url_site_web_2));
		 $url_site_2 = urldecode($res->url_site_web_2);
		 $image_artiste = $res->url_pj;
		 if($res->ville==""){
		 	$ville = "Inconnu";
		 }else{
			$ville = stripslashes(utf8_encode($res->ville));
		 }
		 if($image_artiste == "default_jaquette.png" && !is_readable($image_artiste)){
			 $sql2 = $pdo->query("SELECT * FROM media WHERE id_artiste=".$id);
			 $res2 = $sql2->fetch(PDO::FETCH_OBJ);
			 $image_artiste = $res2->path_media;
		 }else{
			 $image_artiste= $_MUSIC_ROOT.$image_artiste;
		 }
		 ?>
		 <evenement artiste="<?php echo $artiste;?>" bio_artiste="<?php echo $bio_artiste; ?>" id="<?php echo $id; ?>" image_artiste="<?php echo $image_artiste; ?>" url_site="<?php echo $url_site; ?>"  ville="<?php echo $ville; ?>" />
<?php
	 }
?>
<?php echo '</programmation>'; ?>