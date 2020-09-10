 <?php

require("cn.php");
//
if((isset($_POST['id']) && $_POST['id']!="")){
	
	$id = $_POST['id'];

	if($pdo->exec("DELETE FROM playlist_titre WHERE id_playlist='".$id."'")){
	

		if($pdo->exec("DELETE FROM playlist WHERE id_playlist='".$id."'")){
			echo true;	
		}else{
			echo false;	
		}	
	
	}
	
}
?>

