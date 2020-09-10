<?php
require_once("init.php");
require_once('cn.php');
//
$publique = $_POST['publique'];
$playlist = $_POST['playlist'];
//
if(isset($playlist) && $playlist!="0"){
	$pdo->exec('UPDATE playlist SET publique_playlist='.$publique.' WHERE id_playlist='.$playlist);
}
?>
