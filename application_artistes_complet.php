<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$sql = $pdo->query('SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo where id_artiste <= 932 ORDER BY nom_artiste ASC');
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
		 ?>
		 <evenement artiste="<?php echo $artiste;?>" bio_artiste="<?php echo $bio_artiste; ?>" id="<?php echo $id ?>"/>
<?php
	 }
?>
<?php echo '</programmation>'; ?>