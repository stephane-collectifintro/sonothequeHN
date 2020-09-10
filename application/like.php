<?php


require_once("../cn.php");
$uid = $_POST['id_utilisateur'];
$id = $_POST['id'];
$action = $_POST['action'];
$type = $_POST['type'];
$field = $type;
if ($type=="titre")	$field="chanson";
$rows['rep'];

$sql_favori_radio = $pdo->prepare("SELECT * FROM favori_".$type." WHERE id_".$field."=:id AND id_utilisateur=:id_utilisateur");

	if ($action=="add"):	
		$sql_favori_radio->execute(array("id"=>$id, "id_utilisateur"=>$uid));
		if($sql_favori_radio->fetch(PDO::FETCH_OBJ)){
			$rows['rep'] = array( 'success' => 'ready');
			print json_encode($rows);
		}else{
			if($pdo->exec("INSERT INTO favori_".$type." SET id_".$field."=".$id.", id_utilisateur=".$uid)):
			$rows['rep'] = array( 'success' => 'done');
			print json_encode($rows);
			else:
				$rows['rep'] = array( 'success' => 'failed');
				print json_encode($rows);	
			endif;
		}
		

	else:

		if($pdo->exec("DELETE FROM favori_".$type." WHERE id_".$field."=".$id." AND id_utilisateur=".$uid)):
			$rows['rep'] = array( 'success' => 'disliked');
			print json_encode($rows);
		else:
			$rows['rep'] = array( 'success' => 'failed');
			print json_encode($rows);
		endif;

	endif;


?>

