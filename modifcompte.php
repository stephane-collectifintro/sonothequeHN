<?php
require_once("init.php");
require_once("cn.php");
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
if(isset($_POST["mdp"]) && $_POST["mdp"]!=""){
	
	$mdp = securite_bdd(md5($_POST["mdp"]));
	if($sql = $pdo->exec("UPDATE utilisateur SET password_utilisateur='".$mdp."' WHERE id_utilisateur='".$_SESSION['id_utilisateur']."'")){
		echo 'Votre mot de passe a bien été modifié';	
	}
}


if(!isset($_POST["mdp"]) && $_POST["mdp"]==""){
	
	$nom = securite_bdd($_POST["nom"]);
	$prenom = $_POST["prenom"];
	$mail = securite_bdd($_POST["mail"]);
	$tel = $_POST["tel"];
	$adresse = securite_bdd($_POST["adresse"]);
	$cp = securite_bdd($_POST["cp"]);
	$ville = securite_bdd($_POST["ville"]);
	//
	if($sql = $pdo->exec("UPDATE utilisateur SET nom_utilisateur='".$nom."', prenom_utilisateur='".$prenom."', mail_utilisateur='".$mail."', tel_utilisateur='".$tel."', adresse_utilisateur='".$adresse."', cp_utilisateur='".$cp."', ville_utilisateur='".$ville."' WHERE id_utilisateur='".$_SESSION['id_utilisateur']."'")){
		echo 'Votre compte a bien été mis à jour';	
	}
}
?>
