<?php
session_start();

require_once 'class/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
 header('Location:/mobile/');
}
if(!isset($_SESSION['artiste'])){
	 $_SESSION['artiste'] = array();
}

if(!isset($_SESSION['album'])){
	 $_SESSION['album'] = array();
}

ob_start();
system('ipconfig /all');
$mycom=ob_get_contents(); 
ob_clean();
$findme = "Physical";
$pos = strpos($mycom, $findme);
$macp=substr($mycom,($pos+36),17);


$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];


//print_r($_SESSION);



	
?>
