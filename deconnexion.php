<?php
session_start();
//
unset($_SESSION['id_utilisateur']);
unset($_SESSION['nom_utilisateur']);	
unset($_SESSION['prenom_utilisateur']);
unset($_SESSION['fb_token']);
?>
<?php include('view/logout.php'); ?>
