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
		 $artiste = str_replace ( '"' , "'" , $artiste );
		 $artiste = str_replace ( "&" , "et" , $artiste );  
		 $artiste = str_replace ( "#" , "" , $artiste );  
		 $artiste = str_replace ( "@" , "" , $artiste );  
		 $artiste = str_replace ( "%" , "" , $artiste ); 
		 $artiste = str_replace ( "ñ" , "n" , $artiste ); 
		 $artiste = str_replace ( "Ñ" , "N" , $artiste );
		 $artiste = str_replace ( "$" , "" , $artiste );
		 $artiste = str_replace ( "À" , "A" , $artiste );
			
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
		 $bio_artiste = str_replace ( "$" , "" , $bio_artiste );
		 $bio_artiste = str_replace ( "À" , "A" , $bio_artiste );

		 $bio_artiste = str_replace ( "<span style='font-family: Arial, sans-ser" , "" , $bio_artiste );
		 $url_site = stripslashes(utf8_encode($res->url_site_web));
			$url_verif =  explode( '?', $url_site );

		/* $url_site_2 = stripslashes(utf8_encode($res->url_site_web_2));
		 $url_site_2 = urldecode($res->url_site_web_2);*/
			
		$caracteres = array(
		'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
		'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
		'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
		'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
		'Œ' => 'oe', 'œ' => 'oe',
		'$' => 's');
 
	$artiste = strtr($artiste, $caracteres);
	$artiste = trim($artiste, '-');
	$artiste = strtolower($artiste);

$bio_artiste = strtr($bio_artiste, $caracteres);
	$bio_artiste = preg_replace('#[^A-Za-z0-9]+#', '-', $bio_artiste);
	$bio_artiste = trim($bio_artiste, '-');
	$bio_artiste = strtolower($bio_artiste);

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
		 <evenement artiste="<?php echo $artiste;?>" bio_artiste="<?php echo $bio_artiste; ?>"  id="<?php echo $id ?>" image_artiste="<?php echo $image_artiste; ?>" url_site="<?php echo $url_verif[0]; ?>"  ville="<?php echo $ville; ?>" />
<?php print_r($res);
	 }
?>
<evenement artiste="toto" bio_artiste="titi"  id="<?php echo $id ?>" image_artiste="toto" url_site="titi.com"  ville="rouen" />
<?php echo '</programmation>'; 

?>