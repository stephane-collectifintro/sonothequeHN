<?php

require("cn.php");
//
if(isset($_POST["comment"]) && $_POST["comment"]!=""){
	
	$comment = $_POST["comment"];
	$id_artiste = $_POST["id_artiste"];
	$type_commentaire = $_POST["type_commentaire"];
	
	$sql = $pdo->exec("INSERT INTO commentaire SET id_artiste='".$id_artiste."', id_utilisateur='".$_SESSION['id_utilisateur']."', type_commentaire='".$type_commentaire."', texte_commentaire='".$comment."', date_commentaire='".date('Y-m-d H:i:s')."'");


}
?>