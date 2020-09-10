<?php
session_start();
//
if($_GET['page']!='connexion'){
	if($_SESSION['user']['id']==""){
		header("Location: connexion.php");
			
	}
}
/*$fichierCourant = $_SERVER["PHP_SELF"];
$parties = explode('/', $fichierCourant );
$pages = trim($parties[count($parties) - 1]);
if($pages=="index.php"){
	header("Location:conseil.php");
}*/
?>
