<?php
require('../session.php');
require('../../cn.php');
require('../../class/sql.class.php');
require('../../class/texte.class.php');
require_once("../../fonctions/fonctions.php");
$max_file_size=4194304;
$upload_dir='../media/';

//var_dump($_FILES);
$upload_dir = $_POST['datadir'];
//var_dump($upload_dir);
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
      //
      $nextID = $sql->nextID('portfolio_sonotheque');
      //
      $filename = $nextID.'-'.$_SESSION['id'].'-'.$filename;
      //
      $thumb = explode(".",$filename);
      array_pop($thumb);
      $thumb = implode('.',$thumb);

      $thumb_100 = $thumb.'_thumb_100.'.$filenameext;
      $thumb_300 = $thumb.'_thumb_300.'.$filenameext;
      $thumb_500 = $thumb.'_thumb_500.'.$filenameext;
      $thumb_1000 = $thumb.'_thumb_1000.'.$filenameext;
			//par mesure de securité on suppose l'extenion du fichier fausse
			//verifions si notre fichier fait partie des types autorisés



					if(move_uploaded_file($_FILES['croppedImage']['tmp_name'],'../'.$upload_dir.$filename)){

            $champs = array('type_portfolio','url_pj','type_pj','nom_pj');
            $values = array('sonotheque',$upload_dir.$filename,$filenameext,$filename);
            $sql->insert('portfolio_sonotheque',$champs,$values);

            $sql->execute();

            $champs = array('id_jaquette');
            $values = array($sql->insertID());
            $sql->update('album',$champs,$values,"id_album=".$_SESSION['id']);

            $sql->execute();

            //on genere les miniatures

            imagethumb('../musik_sonotk/'.$upload_dir.$filename,'../musik_sonotk/'.$upload_dir.$thumb_100,100, FALSE, TRUE);
            imagethumb('../musik_sonotk/'.$upload_dir.$filename,'../musik_sonotk/'.$upload_dir.$thumb_300,300, FALSE, TRUE);
            imagethumb('../musik_sonotk/'.$upload_dir.$filename,'../musik_sonotk/'.$upload_dir.$thumb_500,500, TRUE, TRUE);
            imagethumb('../musik_sonotk/'.$upload_dir.$filename,'../musik_sonotk/'.$upload_dir.$thumb_1000,1000, TRUE, TRUE);



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
