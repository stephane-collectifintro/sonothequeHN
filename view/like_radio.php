<?php 
require_once("../cn.php");
$uid = $_POST['id_utilisateur'];
$rid = $_POST['id_radio'];
$action = $_POST['action'];
//


	if ($action=="add"):
		
		$count = $pdo->exec("INSERT INTO favori_radio SET id_radio=".$rid.", id_utilisateur=".$uid);
		if($count):
			print "done";
		else:
			print "failed";
		endif;

	else:

		$count = $pdo->exec("DELETE FROM favori_radio WHERE id_radio=".$rid." AND id_utilisateur=".$uid);
		if($count):
			print "done";
		else:
			print "failed";
		endif;

	endif;



?>