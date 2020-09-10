<?php
session_start();
require("cn.php");
//
$login = $_POST["login"];
$mdp = md5($_POST["mdp"]);

$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$login."' AND password_utilisateur='".$mdp."' AND valide_utilisateur='oui'");
$res = $sql->fetch(PDO::FETCH_OBJ);
	
//
if($sql->rowCount()>0):
	
	$_SESSION['id_utilisateur'] = $res->id_utilisateur;
	$_SESSION['nom_utilisateur'] = $res->nom_utilisateur;
	$_SESSION['prenom_utilisateur'] = $res->prenom_utilisateur;
	$_SESSION['type_utilisateur'] = $res->id_type_utilisateur;
	echo '<script > console.log('.$_SESSION['id_utilisateur'].');</script>';
	echo '<script src="js/login.js"></script>';
	include('view/login.php');

else:
		
?>

<script>alert('compte inexistant ou non valide');</script>
<?php include('view/logoff.php'); ?>

<?php
endif;
?>
