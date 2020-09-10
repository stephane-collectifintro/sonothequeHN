<?php

$sql = new sql();

//- - - - - - - - - - -  //
//- - - - ALBUM - - - -  //
//- - - - - - - - - - -  //

$sql->select('album',"id_album='".$id."'");
$sql->execute();
$res = $sql->result();
//
$titre = utf8_encode($res['titre']);
$artiste = utf8_encode($res['id_artiste']);
$style = utf8_encode($res['id_type_style']);
$annee = utf8_encode($res['annee_sortie']);
$jaquette = utf8_encode($res['id_jaquette']);
$support = utf8_encode($res['support']);
$commentaire = utf8_encode($res['commentaire_album']);
$nom_stockage = utf8_encode($res['nom_stockage']);
$droit = utf8_encode($res['gestion_droit']);

//- - - - - - - - - - - -  //
//- - - - ARTISTE - - - -  //
//- - - - - - - - - - - -  //

$sql->select("artiste",'id_artiste='.$artiste);
$sql->execute();
$res = $sql->result();
//
$nom_artiste = utf8_encode($res['nom_artiste']);
$nom_stockage_artiste = utf8_encode($res['nom_stockage']);

//
//============== SUPPR TRACK =================//
//
if(isset($_GET['supprtrack']) && $_GET['supprtrack']!=""){
	unlink($_GET['path']);
		//
	$sql->delete('portfolio_sonotheque','id_pj='.$_GET['supprtrack']);
	if($sql->execute()){
		//
		$sql->delete('chanson','id_morceau='.$_GET['supprtrack']);
		if($sql->execute()){
			echo "<script>window.location.href='album-".$id.".php';</script>";
		}
	}


}
//
//============== SUPPR JACKETTE =================//
//
if(isset($_GET['idphoto']) && $_GET['idphoto']!=""){

	$tab = glob("../musik_sonotk/".$nom_stockage_artiste."/".$nom_stockage.'/'.$_GET['idphoto'].'*');
	foreach($tab as $filename){
		if(file_exists($filename)){
			unlink($filename);
		}
	}
	//
	$champs = array('id_jaquette');
	$values = array('');
	$sql->update('album','id_album='.$_GET['idphoto']);
	$sql->execute();
	$sql->delete('portfolio_sonotheque','id_pj='.$_GET['idphoto']);
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}

}
//
//============== INFOS =================//
//
if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$artiste = utf8_decode($_POST['artiste']);
	$titre = addslashes(utf8_decode($_POST['titre']));
	$style = utf8_decode($_POST['style']);
	$annee = utf8_decode($_POST['annee']);
	$support = addslashes(utf8_decode($_POST['support']));
	$droit = $_POST['droit'];
	$commentaire = addslashes(utf8_decode($_POST['commentaire']));

	//update type_album
	$champs = array('id_artiste','id_type_style','titre','annee_sortie','support','gestion_droit','commentaire_album');
	$values = array($artiste,$style,$titre,$annee,$support,$droit,$commentaire);
	$sql->update('album',$champs,$values,"id_album='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}

}

//
//============== PERSONNE =================//
//
if((isset($_POST['personne']) && $_POST['personne']!==0) && (isset($_POST['role']) && $_POST['role']!==0)){
	//
	$personne = utf8_encode($_POST['personne']);
	$role = utf8_encode($_POST['role']);
	//update type_album
	$champs = array('id_personne','id_album','id_type_role');
	$values = array($personne,$id,$role);
	$sql->insert('a_un_role',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}
}

//
//============== SUPPR PERSONNE =================//
//
if(isset($_GET['arole']) && $_GET['arole']!=''){
	//
	$sql->delete('a_un_role',"id_a_un_role=".$_GET['arole']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}
}

//
//============== STRUCTURE =================//
//
if((isset($_POST['structure']) && $_POST['structure']!==0) && (isset($_POST['rolestructure']) && $_POST['rolestructure']!==0)){
	//
	$structure = utf8_encode($_POST['structure']);
	$rolestructure = utf8_encode($_POST['rolestructure']);
	//
	$champs = array('id_album','id_structure','id_type_role_structure_album');
	$values = array($id,$structure,$rolestructure);
	$sql->insert('structure_role_album',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}

}
//
//============== SUPPR STRUCTURE =================//
//
if(isset($_GET['arolestructure']) && $_GET['arolestructure']!=''){
	//
	$sql->delete('structure_role_album',"id_structure_role_album=".$_GET['arolestructure']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='album-".$id.".php';</script>";
	}

}




//============== PHOTOS =================//

function FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg'), $max_file_size=1048576, $upload_dir="", $callbackpage=''){

  if(!is_numeric($max_file_size)){
    $max_file_size = 1048576;
  }

  $max_file_size_Mo = $max_file_size/1048576;
  if(!isset($_POST['submitted'])){

    $form = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
    <input type="hidden" name="submitted" value="TRUE" id="'.time().'">
    <input type="hidden" name="MAX_FILE_SIZE" value="'.$max_file_size.'">';
    for($x=0;$x<$num_of_uploads;$x++){
      $form .=  '<input id="inputPhoto" type="file" onchange="readURL(this);" datadir="../musik_sonotk/'.$upload_dir.'" name="file[]"><font color="red">*</font><br /><br />';
    }
    $form .= '<br><font color="red">*</font>
               Type(s) de fichiers autorisés : ';
    $y=count($file_types_array);
  for($x=0;$x<$y;$x++){
      if($x<$y-1){
        $form .= $file_types_array[$x].', ';
      }else{
        $form .= $file_types_array[$x].'.';
      }
    }
	$form .= "<br><font color='red'>*</font> Poids Max autorisé : ".($max_file_size/1024/1024)." Mo, tout fichier excédant le poids ne sera pas pris en compte<br><br>";
    $form .= '</footer></form>';
    echo $form;



  }else{


		$sql = new sql();

		foreach($_FILES['file']['error'] as $key => $value){

			if($_FILES['file']['name'][$key]!=""){
				if($value==UPLOAD_ERR_OK){
					$origfilename = $_FILES['file']['name'][$key];
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


					$file_ext_allow = FALSE;
					//par mesure de securité on suppose l'extenion du fichier fausse
					//verifions si notre fichier fait partie des types autorisés
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
						$file_ext_allow = TRUE;
					}

					if($file_ext_allow){
						if($_FILES['file']['size'][$key]<$max_file_size){

							if(move_uploaded_file($_FILES['file']['tmp_name'][$key],'../musik_sonotk/'.$upload_dir.$filename)){

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
								echo('Une erreur est survenue lors du transfert de '.'<strong>'.$upload_dir.$filename.'</strong><br />');
								exit();
							}
						}else{
							echo('La taille du fichier '.''.$origfilename.''.' excède les '.$max_file_size_Mo.' Mo autorisé(s)');
							exit();
						}
					}else{
						echo('Le fichier '.''.$origfilename.''.'  a une extension invalide, ERREUR DE TRANSFERT !<br />');
						exit();
					}
				}else{
					echo('Une erreur est survenue lors du transfert de vos titres');
					exit();
				}
			}
		}

		if($callbackpage!=''){
			echo '<script>window.location.href="'.$callbackpage.'";</script>';
		}
	}
}
//============== FIN PHOTOS =================//


//============== TITRE =================//

function FILE_UPLOADER2($num_of_uploads=1, $file_types_array=array('jpg','gif','png','mp3','bmp','swf','flv','mpeg','jpeg'), $max_file_size=1048576, $upload_dir="", $callbackpage=''){
  if(!is_numeric($max_file_size)){
    $max_file_size = 1048576;
  }

  $max_file_size_Mo = $max_file_size/1048576;
  if(!isset($_POST['submitted2'])){

    $form = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
    <input type="hidden" name="submitted2" value="TRUE" id="'.time().'">
    <input type="hidden" name="MAX_FILE_SIZE2" value="'.$max_file_size.'">';
    for($x=0;$x<$num_of_uploads;$x++){
      $form .=  '<input type="file" name="file2[]"><font color="red">*</font><br /><br />';
    }
    $form .= '<br><font color="red">*</font>
               Type(s) de fichiers autorisés : ';
    $y=count($file_types_array);
  for($x=0;$x<$y;$x++){
      if($x<$y-1){
        $form .= $file_types_array[$x].', ';
      }else{
        $form .= $file_types_array[$x].'.';
      }
    }
	$form .= "<br><font color='red'>*</font> Poids 10Max autorisé : 70"./*($max_file_size/1024/1024).*/" Mo, tout fichier excédant le poids ne sera pas pris en compte<br><br>";
    $form .= '<footer><input type="submit" value="Envoyer les titres"></footer></form>';
    echo $form;



  }else{

		if(!file_exists($upload_dir)){
			mkdir($upload_dir);
		}
		$sql = new sql();
		$i=0;
		foreach($_FILES['file2']['error'] as $key => $value){
			if($_FILES['file2']['name'][$key]!=""){
				if($value==UPLOAD_ERR_OK){
					$origfilename = $_FILES['file2']['name'][$key];
					$origfiletmpname = $_FILES['file2']['tmp_name'][$key];

					$chanson = explode('.',$origfilename);
					array_pop($chanson);
					$chanson = implode('.',$chanson);

					$txt = new texte();
					$filename = $txt ->cleanFile($origfilename);

					$getID3 = new getID3;
					$ThisFileInfo = $getID3->analyze($_FILES['file2']['tmp_name'][$key]);

					/*echo "<pre>";
					var_dump($ThisFileInfo);
					echo "</pre>";*/

					$filenameext = $ThisFileInfo['fileformat'];
					$titre_chanson = addslashes(utf8_decode($ThisFileInfo['tags']['id3v2']['title'][0]));
					$track = $ThisFileInfo['tags']['id3v2']['track_number'][0];
					$duree = $ThisFileInfo['playtime_string'];

					//echo $chanson." (".$filename.") (type:".$filenameext.")";

					$file_ext_allow = FALSE;
					//
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
						$file_ext_allow = TRUE;
					}

					if($file_ext_allow){
						if($_FILES['file2']['size'][$key]<$max_file_size){

							if(move_uploaded_file($_FILES['file2']['tmp_name'][$key],'../musik_sonotk/'.$upload_dir.$filename)){


								$champs = array('type_portfolio','url_pj','type_pj','nom_pj');
								$values = array('sonotheque',$upload_dir.$filename,$filenameext,$filename);
								$sql->insert('portfolio_sonotheque',$champs,$values);
								$sql->execute();

								$insertid = $sql->insertID();

								$champs = array('id_album','nom','duree','piste','id_morceau');
								$values = array($_SESSION['id'],$titre_chanson,$duree,$track,$insertid);
								$sql->insert('chanson',$champs,$values);

								$sql->execute();
								unset($_SESSION['nb_file']);

							}else{
								echo('Une erreur est survenue lors du transfert de <strong>'.$origfilename.'</strong><br />');
								exit();
							}
						}else{
							echo('La taille du fichier '.''.$origfilename.''.' excède les '.$max_file_size_Mo.' Mo autorisé(s)');
							exit();
						}
					}else{
						echo('Le fichier '.''.$origfilename.''.'  a une extension invalide, ERREUR DE TRANSFERT !<br />');
						exit();
					}
				}else{
					echo('Une erreur est survenue lors du transfert de vos titres');
					exit();
				}
			}
		}

		if($callbackpage!=''){

			echo '<script>window.location.href="'.$callbackpage.'";</script>';
		}
	}
}
//============== FIN PHOTOS =================//


?>

<div id="content">
<div class="titre">MODIFIER album</div>
	<?php

	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <article>
        <header>
          INFORMATION
        </header>
        <span class='champs'><strong>Artiste :</strong><br />

        	<select name="artiste" id="artiste" >
                <option value="0">---</option>
                <?php
                    $sql2 = new sql();
                    $sql2->select("artiste",'','','ORDER BY nom_artiste');
                    $sql2->execute();
                    while($res2 = $sql2->result()){
                        if($artiste==$res2['id_artiste']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                ?>
                <option value="<?php echo $res2['id_artiste']; ?>" <?php echo $selected ?> ><?php echo utf8_encode(stripslashes($res2['nom_artiste'])); ?></option>
                <?php } ?>
        	</select>
        	<a href="ajout_artiste.php" class="lien_annexe"></a>
        </span>

        <span class='champs'><strong>Titre :</strong><br /><input type="text" name="titre" value=" <?php print stripslashes($titre);  ?>" /></span>

        <span class='champs'><strong>Style :</strong><br />

        	<select name="style" id="style" >
                <option value="0">---</option>
                <?php
                    $sql2 = new sql();
                    $sql2->select("type_style",'','','ORDER BY nom');
                    $sql2->execute();
                    while($res2 = $sql2->result()){
                        if($style==$res2['id_type_style']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                ?>
                <option value="<?php echo $res2['id_type_style']; ?>" <?php echo $selected ?> ><?php echo utf8_encode($res2['nom']); ?></option>
                <?php } ?>
        	</select>
        	<a href="ajout_type_style.php" class="lien_annexe"></a>
        </span>

        <span class='champs'><strong>Année :</strong><br /><input type="text" name="annee" value="<?php echo $annee;  ?>" /></span>

        <span class='champs'><strong>Support :</strong><br />

             <select name="support" id="support" >
        	<option value="0">---</option>
        	<?php
				$sql2 = new sql();
				$sql2->select("type_support",'','','ORDER BY nom_type_support');
				$sql2->execute();
				while($res2 = $sql2->result()){
					if($support==utf8_encode($res2['nom_type_support'])){
						$selected = "selected";
					}else{
						$selected = "";
					}
			?>
        	<option <?php echo $selected ?> ><?php echo utf8_encode($res2['nom_type_support']); ?></option>
            <?php } ?>
        </select>
        <a href="ajout_type_support.php" class="lien_annexe"></a>
        </span>
        <span class='champs'><strong>Droit de diffusion :</strong><br />
        <select name="droit" id="droit">

            <option value="3" <?php if($droit==3){ echo "selected"; } ?> >Pas d'autorisation</option>
            <option value="2" <?php if($droit==2){ echo "selected"; } ?> >Autorisation de diffusion</option>
        	<option value="1" <?php if($droit==1){ echo "selected"; } ?> >Adhérent SACEM</option>

        </select>
         </span>
        <span class='champs'><strong>Commentaire :</strong><br />
        	<textarea name="commentaire"><?php echo $commentaire; ?></textarea>
        </span>

        <footer><input type="submit" value="Modifier"/></footer>

    </article>
    </form>





    <article>
    	<header>
        JAQUETTE
        </header>

        <?php

		$sql->select('portfolio_sonotheque','id_pj='.$jaquette);
		$sql->execute();
		if(($res = $sql->result()) && $jaquette!=0){
			$image_jaquette = $res['url_pj'];
		?>
        <span class="media">
            <div class="photo_square" style="background-image:url(../musik_sonotk/<?php echo $image_jaquette; ?>);"><a href="album-<?php echo $id; ?>.php?idphoto=<?php echo $jaquette; ?>&path=../musik_sonotk/<?php echo $image_jaquette; ?>"><div class="close"></div></a></div>
        </span>
        <div class="clear"></div>

        <?php }else{ ?>
					<style type="text/css">
						.image_container img {
							width: 100%; /* This rule is very important, please do not ignore this! */
						}

						article button.btn{
							margin: 10px 10px;
							width: 97%;
						}
					</style>
					<button type="button" class="btn btn-primary pull-left" data-target="#modal" data-toggle="modal">
						Nouvelle photo
					</button>
					<!-- Modal -->
				<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">Cropper l'image</h4>
						</div>
						<div class="modal-body row">
							<div class="img-container">
								<div class="image_container">
									<img id="blah" src="#" alt="your image" class="hidden"/>
								</div>
								<div id="cropped_result" class="col-md-12">
									<div id="cropped_result_view" class="row image_container">
										<img id="img_prev" src="#" alt="your image" class="hidden"/>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<span class='champs'>
							<?php FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg','JPG','JPEG'), $max_file_size=4194304, $upload_dir=$nom_stockage_artiste.'/'.$nom_stockage.'/',$callbackpage='album-'.$id.'.php'); ?>
							</span>
							<progress id="thebar" value="0" style="width: 100%; z-index: 100; margin-top: 20%;" max="0"></progress>
							<button id="crop_button" class="btn btn-secondary hidden">Crop</button>
							<button id="send_button" class="btn btn-success hidden">Valider</button>
							<button id="bt_close" type="button" class="btn btn-default" >Close</button>
						</div>
					</div>
				</div>
				</div>
        <?php } ?>


            <div class="clear"></div>
    </article>






    <article>
    	<header>
        TRACKS<a id="titre"></a>
        </header>
        <span class="champs">
        <table cellspacing="10">
        <?php
		$sql->select('chanson INNER JOIN portfolio_sonotheque ON chanson.id_morceau = portfolio_sonotheque.id_pj','id_album='.$id,"","ORDER BY piste ASC");
		$sql->execute();
		$nb_titre = $sql->getNumRows();
		while($res = $sql->result()){

			$piste_chanson = $res['piste'];
			$duree_chanson = $res['duree'];
			$nom_chanson = utf8_encode($res['nom']);
			$id_pj = $res['id_pj'];
			$path = $res['url_pj'];
			$nom_fichier = $res['nom_pj'];

		?>


			<tr>

            	<td ><audio controls width="40%" id="player<?php echo $id_pj; ?>" >

          <source src="<?php echo $HOST.'/musik_sonotk/'.$path; ?>" type="audio/mpeg">
        </audio>


        </td>
        <td width="70%"><?php echo $piste_chanson.' - '.$nom_chanson.' <i>('.$duree_chanson.')</i> '; ?></td>
        <td width="10"><a href="album-<?php echo $id; ?>.php?supprtrack=<?php echo $id_pj; ?>&path=../musik_sonotk/<?php echo $path; ?>"><img src="images/bin.png" height="16" /></a></td>
        </tr>


        <?php }?>
        </table>
        </span>
        <div class="clear"></div>
       	<?php
		if(isset($_GET['nbfile'])){
			$_SESSION['nb_file'] = $_GET['nbfile'];
		}
		?>

        <span class="champs">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="get">
       	Ajouter
        <select name="nbfile">
        	<?php for($i=0;$i<25;$i++){ ?>
            <option <?php if($_SESSION['nb_file']==$i) echo "SELECTED"; ?>><?php echo $i; ?></option>
            <?php } ?>
        </select>
        titre(s) :
         <input type="submit" value="ok">
        </form>
        </span>

        <span class='champs'>
        <?php

		if(isset($_SESSION['nb_file'])){
			FILE_UPLOADER2($num_of_uploads=$_SESSION['nb_file'], $file_types_array=array('mp3'), $max_file_size=70485760, $upload_dir=$nom_stockage_artiste.'/'.$nom_stockage.'/',$callbackpage='album-'.$id.'.php');
		}
		?>
        </span>
        <span class='champs' style="text-align:right;">
        	<a href="personne_titre-<?php echo $id; ?>.php" style="display:inline-block; background-color:#CCC; color:#FFF; padding:5px;">Rôle Personne/Titre ></a>
        </span>

            <div class="clear"></div>
    </article>

    <article>
    	<header>
        PERSONNES ASSOCIÉS
        </header>
        <span class="champs">
        <u><strong>MUSICIEN</strong></u>
        <br><br>
        <ul>
        <?php
			$sql->select("personne INNER JOIN a_un_role ON personne.id_personne = a_un_role.id_personne INNER JOIN type_role ON type_role.id_type_role=a_un_role.id_type_role","type_type_role='musicien' AND id_album=".$id,"","ORDER BY nom_personne, prenom_personne");

			$sql->execute();
			while($res = $sql->result()){

				$id_personne = $res['id_personne'];
				$prenom = utf8_encode($res['prenom_personne']);
				$nom = utf8_encode($res['nom_personne']);
				$nom_role = utf8_encode($res['nom_type_role']);

				echo '<li><a href="album-'.$id.'.php?arole='.$res['id_a_un_role'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_personne.'.php">'.$nom.' '.$prenom.'</a></i></li>';

			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucun musicien associé</i>";
			}
		?>
        </ul>
        <br><br>
        <u><strong>TECHNICIEN</strong></u>
        <br><br>
        <ul>
        <?php
			$sql->select("personne INNER JOIN a_un_role ON personne.id_personne = a_un_role.id_personne INNER JOIN type_role ON type_role.id_type_role=a_un_role.id_type_role","type_type_role='technicien' AND id_album=".$id,"","ORDER BY nom_personne, prenom_personne");

			$sql->execute();
			while($res = $sql->result()){

				$id_personne = $res['id_personne'];
				$prenom = utf8_encode($res['prenom_personne']);
				$nom = utf8_encode($res['nom_personne']);
				$nom_role = utf8_encode($res['nom_type_role']);

				echo '<li><a href="album-'.$id.'.php?arole='.$res['id_a_un_role'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_personne.'.php">'.$nom.' '.$prenom.'</a></i></li>';

			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucun technicien associé</i>";
			}
		?>
        </ul>
        </span>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
        <span class="champs">
        	Nom :
        	<select name="personne">
            	<option value='0'>---</option>
            	<?php
					$sql->select("personne","","","ORDER BY nom_personne, prenom_personne");
					$sql->execute();
					while($res = $sql->result()){

						$id_personne = $res['id_personne'];
						$prenom = utf8_encode($res['prenom_personne']);
						$nom = utf8_encode($res['nom_personne']);
				?>
                <option value="<?php echo $id_personne; ?>"><?php echo $nom.' '.$prenom; ?></option>
                <?php
					}
				?>
            </select>

            <select name="role">
            	<option value='0'>---</option>
            	<?php
					$sql->select("type_role","","","ORDER BY type_type_role ASC, nom_type_role ASC");
					$sql->execute();
					while($res = $sql->result()){

						$id_role = $res['id_type_role'];
						$role = utf8_encode($res['nom_type_role']);
						$typerole = utf8_encode($res['type_type_role']);
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role.' ('.$typerole.')'; ?></option>
                <?php
					}
				?>
            </select>
        </span>
        <footer><input type="submit" value="Ajouter"/></footer>
        </form>
   </article>


   <article>
    	<header>
        STRUCTURES ASSOCIÉS
        </header>
        <span class="champs">
        <ul>
        <?php
			$sql->select("structure_sonotk
INNER JOIN structure_role_album ON structure_sonotk.id_structure = structure_role_album.id_structure
INNER JOIN type_role_structure_album ON type_role_structure_album.id_type_role_structure_album=structure_role_album.id_type_role_structure_album","structure_role_album.id_album=".$id,"","ORDER BY nom_structure");
			//echo $sql->getQuery();
			$sql->execute();
			while($res = $sql->result()){

				$id_structure = $res['id_structure'];
				$nom = utf8_encode($res['nom_structure']);
				$nom_role = utf8_encode($res['nom_type_role_structure_album']);

				echo '<li><a href="album-'.$id.'.php?arolestructure='.$res['id_structure_role_album'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_structure.'.php">'.$nom.'</a></i></li>';

			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucune personne associé</i>";
			}
		?>
        </ul>

        </span>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
        <span class="champs">
        	Structure :
        	<select name="structure">
            	<option value='0'>---</option>
            	<?php
					$sql->select("structure_sonotk","","","ORDER BY nom_structure");
					$sql->execute();
					while($res = $sql->result()){

						$id_structure = $res['id_structure'];
						$nom = utf8_encode($res['nom_structure']);

				?>
                <option value="<?php echo $id_structure; ?>"><?php echo $nom; ?></option>
                <?php
					}
				?>
            </select>
           	<br><br>Rôle :
            <select name="rolestructure">
            	<option value='0'>---</option>
            	<?php
					$sql->select("type_role_structure_album","","","ORDER BY nom_type_role_structure_album ASC");
					$sql->execute();
					while($res = $sql->result()){

						$id_role = $res['id_type_role_structure_album'];
						$role = utf8_encode($res['nom_type_role_structure_album']);
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role; ?></option>
                <?php
					}
				?>
            </select>
        </span>
        <footer><input type="submit" value="Ajouter"/></footer>
        </form>
   </article>
</div>

	<script type="text/javascript" defer>
	$("#bt_close").on('click', function(){
		 location.reload();
	});
		function readURL(input) {
            if (input.files && input.files[0]) {
								$("span.champs form").addClass( "hidden" );
                var reader = new FileReader();
                reader.onload = function (e) {

                    $('#blah').attr('src', e.target.result);
										$('#blah').removeClass( "hidden" );
										$('#crop_button').removeClass( "hidden" );

                };

								console.log(input.files[0]);
                reader.readAsDataURL(input.files[0]);

                setTimeout(initCropper, 1000);
            }
        }

				function initCropper(){
					var minAspectRatio = 0.5;
      		var maxAspectRatio = 1.5;
		    	var image = document.getElementById('blah');

					var cropper = new Cropper(image, {
		        ready: function () {
		          var cropper = this.cropper;
		          var containerData = cropper.getContainerData();
		          var cropBoxData = cropper.getCropBoxData();
		          var aspectRatio = cropBoxData.width / cropBoxData.height;
		          var newCropBoxWidth;

		          if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
		            newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

		            cropper.setCropBoxData({
		              left: (containerData.width - newCropBoxWidth) / 2,
		              width: newCropBoxWidth
		            });
		          }
		        },
		        cropmove: function () {
		          var cropper = this.cropper;
		          var cropBoxData = cropper.getCropBoxData();
		          var aspectRatio = cropBoxData.width / cropBoxData.height;

		          if (aspectRatio < minAspectRatio) {
		            cropper.setCropBoxData({
		              width: cropBoxData.height * minAspectRatio
		            });
		          } else if (aspectRatio > maxAspectRatio) {
		            cropper.setCropBoxData({
		              width: cropBoxData.height * maxAspectRatio
		            });
		          }
		        }
		      });



				// On crop button clicked
				document.getElementById('crop_button').addEventListener('click', function(){

		    		var imgurl =  cropper.getCroppedCanvas().toDataURL("image/jpeg");

						$('#img_prev').removeClass( "hidden" );
						$( "#img_prev" ).addClass( "img-responsive" );
						$("#img_prev").attr("src",imgurl);
						$('#send_button').removeClass( "hidden" );
		    		/*var img = document.createElement("img");
		    		img.src = imgurl;*/

		    		//document.getElementById("cropped_result_view").appendChild(img);
						//$( "#cropped_result_view img" ).addClass( "img-responsive" );

					});
		    		/* ----------------	SEND IMAGE TO THE SERVER------------------------- */
				document.getElementById('send_button').addEventListener('click', function(){
						function afficherAvancement(e){
						   if(e.lengthComputable){
								$('progress').attr({value:e.loaded,max:e.total});
						   }
						};

						cropper.getCroppedCanvas().toBlob(function (blob) {
							console.log($("#inputPhoto").attr("datadir"));
							var formData = new FormData();
	 						 formData.append('croppedImage', blob);
							 formData.append('origfilename', $('input[type=file]')[0].files[0]);
							 formData.append('datadir', $("#inputPhoto").attr("datadir"));
	 						 // Use `jQuery.ajax` method
	 						 $.ajax('/admin/views/upload_album.php', {
								 xhr: function() { // xhr qui traite la barre de progression
								   myXhr = $.ajaxSettings.xhr();
								   if(myXhr.upload){ // vérifie si l'upload existe
								      myXhr.upload.addEventListener('progress',afficherAvancement, false);
								   }
								return myXhr;
								 },
	 							 method: "POST",
	 							 data: formData,
	 							 processData: false,
	 							 contentType: false,
	 							 success: function (msg) {
	 								 console.log('Upload success');
									  console.log(msg);
										location.reload();
	 							 },
	 							 error: function () {
	 								 console.log('Upload error');
	 							 }
	 						 });
						 });
					});

		    }
 </script>
