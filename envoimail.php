<?php

$nom = stripslashes($_POST["nom"]);
$prenom = stripslashes($_POST["prenom"]);
$mail = $_POST["mail"];
$tel = stripslashes($_POST["tel"]);
$objet = stripslashes($_POST["objet"]);
$commentaire = stripslashes($_POST["commentaire"]);
//



$headers ='From: "'.$nom.' '.$prenom.'"<'.$mail.'>'."\n"; 
$headers .='Reply-To: '.$mail."\n"; 
$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
$headers .='Content-Transfer-Encoding: 8bit'; 

$message = $commentaire; 

if(mail("contact@sonotheque-normandie.com", $objet, $message, $headers)) echo "Message envoyé !"
							
	
?>
