<?php
require_once("init.php");
require_once('cn.php');

$playlist = $_GET['playlist'];
$order = $_GET['order'];

$sql = $pdo->prepare("UPDATE playlist_titre SET ordre_playlist_titre=:ordre WHERE id_chanson=:chanson AND id_playlist=:playlist");
foreach ($order as $key => $value) {
    $sql->execute(array(":ordre"=>$key, ":chanson"=>$value ,":playlist"=>$playlist));
}


?>
