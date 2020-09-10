<?php
require_once("../init.php");
require_once("../cn.php");
$uid = $_SESSION['id_utilisateur'];
$id = $_POST['id'];
$action = $_POST['action'];
$type = $_POST['type'];
$field = $type;
//
if ($type=="titre")	$field="chanson";



	if ($action=="add"):
		
		if($pdo->exec("INSERT INTO favori_".$type." SET id_".$field."=".$id.", id_utilisateur=".$uid)):
			print "done";
		else:
			print "failed";
		endif;

	else:

		if($pdo->exec("DELETE FROM favori_".$type." WHERE id_".$field."=".$id." AND id_utilisateur=".$uid)):
			print "done";
		else:
			print "failed";
		endif;

	endif;



?>