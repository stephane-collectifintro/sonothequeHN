 <?php

require("cn.php");
//
if((isset($_POST['pid']) && $_POST['pid']!="")){
	
	$id = $_POST['pid'];
	$titre = $_POST['ptitre'];

	//print "UPDATE playlist SET nom_playlist='".$titre."' WHERE id_playlist=".$id;
	if($pdo->exec("UPDATE playlist SET nom_playlist='".$titre."' WHERE id_playlist=".$id)){
		echo true;	
	}else{
		echo false;	
	}	
	
}
?>

