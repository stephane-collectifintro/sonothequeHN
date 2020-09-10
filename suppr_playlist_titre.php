<?php
require_once("init.php");
require_once('cn.php');
//
$id = $_POST['id'];
$playlist = $_POST['playlist'];
//
if(isset($id) && $id!="0"){
	if($pdo->exec('DELETE FROM playlist_titre WHERE id_playlist='.$playlist.' AND id_chanson='.$id)){
		print "done";
	}else{
        print "failed";
    }
}
?>
