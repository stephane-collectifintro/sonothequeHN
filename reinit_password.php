<?php

require("cn.php");

$mail = $_POST["mail"];
//
$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$mail."'");
//
if($sql->rowCount()===0){
	echo "Cette adresse email n'existe pas !";
}else{

	$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
	$nb_caract = 8;
	$pass = "";
	for($u = 1; $u <= $nb_caract; $u++) {
		$nb = strlen($chaine);
		$nb = mt_rand(0,($nb-1));
		$pass.=$chaine[$nb];
	}

	$sql = $pdo->exec("UPDATE utilisateur SET password_utilisateur='".md5($pass)."' WHERE mail_utilisateur='".$mail."'");
	if($sql){
		
			
			$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
			$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n"; 
			$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			
			$message ='Bonjour,<br><br>Votre mot de passe a bien été réinitialisé<br><br>Vous pouvez vous connecter dès maintenant grâce à vos nouveaux identifiants de connexion :<br><br>Identifiant : <strong>'.$mail.'</strong><br>Mot de passe : <strong>'.$pass.'</strong><br><br>Cordialement,<br>L\'équipe de la sonothèque'; 
			
			if(mail($mail, 'Mot de passe réinitialisé sur le site de la Sonothèque Haute-Normandie', $message, $headers)){ 
				echo 'Un mail de confirmation vous a été envoyé !';
			}
			
		
	}else{
		echo "Problème lors de l'opération";
	}
	
}
?>
