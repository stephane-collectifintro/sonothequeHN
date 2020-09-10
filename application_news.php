<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$toto= 0;
    $sql = $pdo->query("SELECT * FROM actualite ORDER BY date_actualite DESC");
    while($res = $sql->fetch(PDO::FETCH_OBJ)){
		$toto ++;
        $id_actualite = $res->id_actualite;
        $actualite = stripslashes(utf8_encode($res->titre_actualite));
		$photo = stripslashes(utf8_encode($res->photo_actualite));
		$date = stripslashes(utf8_encode($res->date_actualite)); 
		$texte = nl2br(utf8_encode($res->texte_actualite));  
		$actualite = str_replace ( "\"" , "'" , $actualite ); 
		$texte = htmlspecialchars($texte);
		$texte = str_replace('<br />', '\n',$texte); 
		$texte = str_replace ( "\"" , "'" , $texte ); 
?>
<evenement titre="<?php echo $actualite;?>" photo="<?php echo $photo; ?>" texte="<?php echo $texte; ?>"/>

<?php 
    }
?>
<evenement titre="" photo="" texte=""/>
<?php echo '</programmation>'; ?>