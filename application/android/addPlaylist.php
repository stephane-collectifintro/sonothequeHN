<?php

require('../../cn.php');
$id_utilisateur = $_GET['id_user'];
$playlist = $_GET['playlist'];

	if($sql = $pdo->exec('INSERT INTO playlist SET nom_playlist="'.$playlist.'", id_utilisateur="'.$id_utilisateur.'"')){
		print "ok";
	}else{
		print "pas ok";
	}


?>
