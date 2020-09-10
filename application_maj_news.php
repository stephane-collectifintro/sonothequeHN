<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
    $sql = $pdo->query("SELECT * FROM actualite ORDER BY date_actualite DESC");
    while($res = $sql->fetch(PDO::FETCH_OBJ)){
        $id_actualite = $res->id_actualite;
        $actualite = stripslashes(utf8_encode($res->titre_actualite));
		$photo = stripslashes(utf8_encode($res->photo_actualite));
		$date = stripslashes(utf8_encode($res->date_actualite)); 
		$actualite = str_replace ( "\"" , "'" , $actualite ); 
		$texte = strip_tags(utf8_encode($res->texte_actualite)); 
		$texte = html_entity_decode(stripslashes($texte),ENT_QUOTES); 
		$texte = htmlspecialchars($texte);
		$texte = str_replace('<br />', '\n',$texte); 
		$texte = str_replace ( "\"" , "'" , $texte ); 
?>
<evenement titre="<?php echo $actualite;?>" photo="<?php echo $photo; ?>" texte="<?php echo $texte; ?>"/>

<?php 
    }
?>
<?php echo '</programmation>'; ?>