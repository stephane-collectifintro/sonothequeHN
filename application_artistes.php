<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php echo '<programmation>'; ?>
<?php
    require('cn.php');
	$sql = $pdo->query('SELECT * FROM artiste ORDER BY nom_artiste ASC');

	 while($res = $sql->fetch(PDO::FETCH_OBJ)){

		 $id = $res->id_artiste;
		 $artiste = utf8_encode($res->nom_artiste);
		 $artiste = str_replace ( "&" , "et" , $artiste ); 
		 $artiste = str_replace ( "\'" , "'" , $artiste ); 
		 ?>
		 <evenement artiste="<?php echo $artiste;?>" id="<?php echo $id ?>"/>
<?php
	 }
?>
<evenement artiste="" id=""/>
<?php echo '</programmation>'; ?>