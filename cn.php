<?php
	
	$host = "mysql51-9.premium";
	$login_connexion = "sonothequedb";
	$password_connexion = "6gb6Dr4TC";
	$dbname = "sonothequedb";
	$pdo_options = array(PDO::ATTR_PERSISTENT => true,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	$pdo = new PDO('mysql:dbname='.$dbname.';host='.$host, $login_connexion,$password_connexion, $pdo_options);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	//

	$db=mysql_connect($host,$login_connexion,$password_connexion) or die ("impossible de se connecter au seveur");
	mysql_select_db($dbname) or die ("impossible de se connecter  la base");
	//$db = new PDO( 'mysql:host=' . $host . ';dbname=' . $dbname, $login_connexion, $password_connexion, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );

	
	$_ROOT = "https://www.sonotheque-normandie.com/";
	$_MUSIC_ROOT = "musik_sonotk/";
	
?>
