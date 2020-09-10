<?php

require('../../cn.php');
$id_chanson = $_GET['id_chanson'];
$id_playlist = $_GET['id_playlist'];

	if($pdo->exec('INSERT INTO playlist_titre SET id_playlist="'.$id_playlist.'", id_chanson="'.$id_chanson.'"')){
		print "ok";
	}else{
		print "pas ok";
	}


?>
