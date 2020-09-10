<?php
require('../cn.php');

$id = $_POST['id'];
$playlist = $_POST['playlist'];


//$id = 351;
//$playlist = 131;

if(isset($id) && $id!="0"){
	if($pdo->exec('DELETE FROM playlist_titre WHERE id_playlist='.$playlist.' AND id_playlist_titre='.$id)){
		print "ok";
	}else{
        print "pas ok";
    }
}
?>
