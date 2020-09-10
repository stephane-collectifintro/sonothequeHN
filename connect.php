<?php
require("init.php");
require("cn.php");
//
//$login = $_POST["login"];
//$mdp = md5($_POST["mdp"]);
// Sécurisation des données reçues
//$login = mysql_real_escape_string($login);
//$mdp = mysql_real_escape_string($mdp);
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
//
$login = $_POST["login"];
$mdp = md5($_POST["mdp"]);
$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$login."' AND password_utilisateur='".$mdp."'");

	
//
if($res = $sql->fetch(PDO::FETCH_OBJ)){
	
	$_SESSION['id_utilisateur'] = $res->id_utilisateur;
	$_SESSION['nom_utilisateur'] = $res->nom_utilisateur;
	$_SESSION['prenom_utilisateur'] = $res->prenom_utilisateur;
	$_SESSION['type_utilisateur'] = $res->id_type_utilisateur;
	echo '<script > console.log('.$_SESSION['id_utilisateur'].');</script>';
	echo '<script src="js/login.js"></script>';
	include('view/login.php');

}else{
		
?>
<script>alert('compte inexistant ou non valide');</script>
<?php include('view/logout.php'); ?>

<?php
	}
?>


?>