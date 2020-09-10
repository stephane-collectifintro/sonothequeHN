<?php

require_once("../../cn.php");
$id = $_GET['id'];

		if($pdo->exec("DELETE FROM playlist WHERE id_playlist='".$id."'")):
			$rows['rep'] = array( 'success' => 'disliked');
			print json_encode($rows);
		else:
			$rows['rep'] = array( 'success' => 'failed');
			print json_encode($rows);
		endif;


?>