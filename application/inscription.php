<?php

require("../cn.php");
$rows['rep'];
//
//
$mail = $_POST["mail"];
$mdp = md5($_POST["mdp"]);

//$mail = "toto@yahoo.fr";
//$mdp = "titi";
//

if (!empty($mail) && isset($mail)){
	$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$mail."'");

	if($sql->rowCount()>0){
				$rows['rep'] = array( 'success' => 'existe');
				print json_encode($rows);

	}else{
	if($sql2 = $pdo->exec("INSERT INTO utilisateur SET id_type_utilisateur='0', structure_utilisateur=' ', nom_utilisateur=' ', prenom_utilisateur=' ', mail_utilisateur='".$mail."', tel_utilisateur=' ', adresse_utilisateur=' ', cp_utilisateur=' ', ville_utilisateur=' ', password_utilisateur='".$mdp."', valide_utilisateur=' '")){
				$rows['id'] = array( 'id' =>  $pdo->lastInsertId());
				
				
				$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
				$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n"; 
				$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
				$headers .='Content-Transfer-Encoding: 8bit'; 
				
				$message ='Bonjour,<br><br>Votre inscription a bien été pris en compte sur le site http://www.sonotheque-hn.com.<br><br>Vous pouvez vous y connecter dès maintenant grâce aux identifiants de connexion suivants :<br><br>Identifiant : <strong>'.$mail.'</strong><br>Mot de passe : <strong>'.$_POST["mdp"].'</strong><br><br>Cordialement,<br>L\'équipe de la sonothèque'; 
				
				mail($mail, 'Bienvenue sur le site de la Sonothèque Haute-Normandie', $message, $headers);
				
				
				$rows['rep'] = array( 'success' => 'done');
				
				print json_encode($rows);
		}else{
			$rows['rep'] = array( 'success' => 'fail');
			print json_encode($rows);
		}
	}
}else{
	$rows['rep'] = array( 'success' => 'email');
	print json_encode($rows);
}


?>
