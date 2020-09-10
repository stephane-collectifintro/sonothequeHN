<?php

require("cn.php");
//
//
function securite_bdd($string){
        // On regarde si le type de string est un nombre entier (int)
        if(ctype_digit($string))
        {
            $string = intval($string);
        }
        // Pour tous les autres types
        else
        {
            $string = mysql_real_escape_string($string);
            $string = addcslashes($string, '%_');
        }
         
        return $string;
    }
$type = securite_bdd($_POST["type"]);

if($type=="1"){
	$structure = "";
	$valide = "oui";
}else{
	$structure = securite_bdd(utf8_decode($_POST["structure"]));
	$valide = "non";
}

$nom = securite_bdd(utf8_decode($_POST["nom"]));
$prenom = securite_bdd(utf8_decode($_POST["prenom"]));
$mail = securite_bdd($_POST["mail"]);
$tel = securite_bdd(utf8_decode($_POST["tel"]));
$adresse = securite_bdd(utf8_decode($_POST["adresse"]));
$cp = securite_bdd(utf8_decode($_POST["cp"]));
$ville = securite_bdd(utf8_decode($_POST["ville"]));
$mdp = securite_bdd(md5($_POST["mdp"]));
//
$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$mail."'");
//
if($sql->rowCount()>0){
	echo 'Votre adresse email est déjà associée à un compte existant !';
}else{
	$sql = $pdo->exec("INSERT INTO utilisateur SET id_type_utilisateur='".$type."', structure_utilisateur='".$structure."', nom_utilisateur='".$nom."', prenom_utilisateur='".$prenom."', mail_utilisateur='".$mail."', tel_utilisateur='".$tel."', adresse_utilisateur='".$adresse."', cp_utilisateur='".$cp."', ville_utilisateur='".$ville."', password_utilisateur='".$mdp."', valide_utilisateur='".$valide."'");
	if($sql){
				
		if($type=="1"){
			
			$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
			$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n"; 
			$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			
			$message ='Bonjour,<br><br>Votre inscription a bien été pris en compte sur le site http://www.sonotheque-hn.com.<br><br>Vous pouvez vous y connecter dès maintenant grâce aux identifiants de connexion suivants :<br><br>Identifiant : <strong>'.$mail.'</strong><br>Mot de passe : <strong>'.$_POST["mdp"].'</strong><br><br>Cordialement,<br>L\'équipe de la sonothèque'; 
			
			if(mail($mail, 'Bienvenue sur le site de la Sonothèque Haute-Normandie', $message, $headers)){ 
				echo 'Merci de votre inscription, vous pouvez vous connecter dès maintenant';
			}
			
			
			
		}else{
			
			$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
			$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n"; 
			$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			
			$message ='Bonjour,<br><br>Votre inscription a bien été pris en compte sur le site http://www.sonotheque-hn.com.<br><br>L\'équipe de la Sonothèque doit tout d\'abord vérifier les informations de votre structure, vous serez prévenu par mail lorsque votre compte sera validé.<br><br>Vous pourrez alors vous connecter sur le site grâce aux identifiants de connexion suivants :<br><br>Identifiant : <strong>'.$mail.'</strong><br>Mot de passe : <strong>'.$_POST["mdp"].'</strong><br><br>Cordialement,<br>L\'équipe de la sonothèque'; 
			
			if(mail($mail, 'Bienvenue sur le site de la Sonothèque Haute-Normandie', $message, $headers)){ 
				echo 'Merci de votre inscription, vous recevrez un mail lorsque l\'équipe de la Sonothèque aura validé votre compte Pro';
			}
			
			///
			
			
			$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
			$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n"; 
			$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			
			$message ='Bonjour,<br><br>Une nouvelle inscription de structure est a vérifier sur le site http://www.sonotheque-hn.com.<br><br>Cordialement,<br>L\'équipe de la sonothèque'; 
			
			$sujet = "";
			
			mail("contact@sonotheque-hn.com", 'Nouvelle inscription de structure sur le site de la sonothèque', $message, $headers);
							
		}
		
	}else{
		echo 'Problème lors de l\'enregistement';
	}
	
}
?>
