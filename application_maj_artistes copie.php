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
		 $artiste = str_replace ( "�" , "n" , $artiste ); 
		 $artiste = str_replace ( "�" , "N" , $artiste );
		 $artiste = str_replace ( '"' , "'" , $artiste );
		 $artiste = str_replace ( "&" , "et" , $artiste );  
		 $artiste = str_replace ( "#" , "" , $artiste );  
		 $artiste = str_replace ( "@" , "" , $artiste );  
		 $artiste = str_replace ( "%" , "" , $artiste ); 
		 $artiste = str_replace ( "�" , "n" , $artiste ); 
		 $artiste = str_replace ( "�" , "N" , $artiste );
		 $artiste = str_replace ( "$" , "" , $artiste );
		 $artiste = str_replace ( "�" , "A" , $artiste );
			
		 $bio_artiste = stripslashes(utf8_encode($res->bio_artiste));
		 $bio_artiste = strip_tags($bio_artiste);
		 $bio_artiste = html_entity_decode($bio_artiste,ENT_QUOTES);
		 $bio_artiste = str_replace ( '"' , "'" , $bio_artiste );
		 $bio_artiste = str_replace ( "&" , "et" , $bio_artiste );  
		 $bio_artiste = str_replace ( "#" , "" , $bio_artiste );  
		 $bio_artiste = str_replace ( "@" , "" , $bio_artiste );  
		 $bio_artiste = str_replace ( "%" , "" , $bio_artiste ); 
		 $bio_artiste = str_replace ( "�" , "n" , $bio_artiste ); 
		 $bio_artiste = str_replace ( "�" , "N" , $bio_artiste );
		 $bio_artiste = str_replace ( "$" , "" , $bio_artiste );
		 $bio_artiste = str_replace ( "�" , "A" , $bio_artiste );

		 $bio_artiste = str_replace ( "<span style='font-family: Arial, sans-ser" , "" , $bio_artiste );
		 $url_site = stripslashes(utf8_encode($res->url_site_web));
			$url_verif =  explode( '?', $url_site );

		/* $url_site_2 = stripslashes(utf8_encode($res->url_site_web_2));
		 $url_site_2 = urldecode($res->url_site_web_2);*/
			
		$caracteres = array(
		'�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '@' => 'a',
		'�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e',
		'�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i',
		'�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o',
		'�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u',
		'�' => 'oe', '�' => 'oe',
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