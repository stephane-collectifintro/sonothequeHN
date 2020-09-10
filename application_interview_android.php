<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste');
	 while($res = $sql->fetch(PDO::FETCH_OBJ)){
  		 $artiste = stripslashes(utf8_encode($res->nom_artiste));
		 $artiste = str_replace('&','et',$artiste); 
		 $artiste = str_replace('ñ','n',$artiste); 
		  $texte = stripslashes(utf8_encode($res->texte_interview));
		 //$texte = strip_tags($texte);
		 $texte = html_entity_decode($texte);
		 $texte = str_replace ( '"' , "'" , $texte ); 
		 $texte = htmlspecialchars($texte);
		 ?>
		 <evenement artiste="<?php echo $artiste;?>" texte="<?php echo $texte; ?>" />
<?php
	 }
?>
<?php echo '</programmation>'; ?>