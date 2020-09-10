<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	// CLIP SEMAINE
    $date = date('Y-m-d');
	$sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste WHERE date_debut_interview<="'.$date.'" ORDER BY date_debut_interview DESC');

	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
		 $photo = $res->photo_interview;
		 $texte = stripslashes(utf8_encode($res->texte_interview));
		 //$texte = strip_tags($texte);
		 $texte = html_entity_decode($texte);
		 $texte = str_replace ( '"' , "'" , $texte ); 
		 $texte = htmlspecialchars($texte);

		$caracteres = array(
		'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
		'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
		'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
		'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
		'Œ' => 'oe', 'œ' => 'oe',
		'$' => 's');

		
			
  		 $artiste = stripslashes(utf8_encode($res->nom_artiste));
		 $artiste = str_replace('&','et',$artiste); 
		 $artiste = str_replace('ñ','n',$artiste);
		
		$artiste = strtr($artiste, $caracteres);
		
 		$texte = strtr($texte, $caracteres);
		 ?>
		 <evenement artiste="<?php echo $artiste;?>" photo="<?php echo $photo; ?>"  texte="<?php echo $texte; ?>"/>
<?php
	 }
?>
<?php echo '</programmation>'; ?>