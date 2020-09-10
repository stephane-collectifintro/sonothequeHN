<?php
require('../session.php');
require('../../cn.php');
require('../../class/sql.class.php');
require('../../class/texte.class.php');
require_once("../../fonctions/fonctions.php");
$max_file_size=4194304;
$upload_dir='../media/';

var_dump($_FILES);
if(!file_exists($upload_dir)){
	mkdir($upload_dir);
}
$sql = new sql();

	if($_FILES['origfilename']['name']!=""){
		if($_FILES['origfilename']['error'] == 0){
			$origfilename = $_FILES['origfilename']['name'];

			//
			$txt = new texte();
			$filename = $txt ->cleanFile($origfilename);
			$filenameext = $txt->getExtension();
				$filename = $_SESSION['id'].'-actualite-'.$filename;
			//par mesure de securité on suppose l'extenion du fichier fausse
			//verifions si notre fichier fait partie des types autorisés



					if(move_uploaded_file($_FILES['croppedImage']['tmp_name'],'../'.$upload_dir.$filename)){

						$champs = array('photo_actualite');
						$values = array($upload_dir.$filename);
						$sql->update('actualite',$champs,$values,'id_actualite='.$_SESSION['id']);

						$sql->execute();

						imagethumb('../'.$upload_dir.$filename,'../'.$upload_dir.$filename,700);



					}else{
						echo('Une erreur est survenue lors du transfert de '.'<strong>'.$origfilename.'</strong><br />');
						exit();
					}
		}else{
			echo('Une erreur est survenue lors du transfert de vos titres');
			exit();
		}
}


?>
