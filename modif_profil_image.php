<?php
	require_once("init.php");
	require_once("cn.php");
	require_once("fonctions/fonctions.php");

	$id = $_SESSION['id_utilisateur'];
    $file = $_FILES['image'];

    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
	
	$uploaddir = 'user/uploads/';
	$ext = explode(".",$file_name);
	$ext = end($ext);
	$uniqid = $id."-".md5(uniqid(rand(), true));
	$uploadfile = $uploaddir . $uniqid . "." . $ext;

	
	if (move_uploaded_file($file_tmp_name, $uploadfile)) {

		imagethumb($uploadfile, $uploadfile , 512 );
	   	
		$sql = $pdo->query("SELECT * FROM utilisateur WHERE id_utilisateur=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);

		$image = $res->photo_utilisateur;

		if(is_readable($image)){
			unlink($image);
		}

		$pdo->exec("UPDATE utilisateur SET photo_utilisateur='".$uploadfile."' WHERE id_utilisateur=".$id);
	    echo $uploadfile;

	} else {

	    echo false;
	}
    
?>