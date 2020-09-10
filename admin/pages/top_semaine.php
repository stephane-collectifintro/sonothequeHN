
<?php
$sql = new sql();
$sql2 = new sql();

if(isset($_GET['idphoto']) && $_GET['idphoto']!=""){
	unlink($_GET['path']);
	
	$champs = array('photo_top_semaine');
	$values = array('');
	$sql->update('top_semaine',$champs,$values,"id_top_semaine='".$id."'");
	if($sql->execute()){
		echo "<script>window.location.href='top_semaine-".$id.".php';</script>";	
	}
	
		
}

//============== INFOS =================//
if((isset($_POST['album']) && $_POST['album']!==0)){
	//
	$album = utf8_decode($_POST['album']);
	$texte = addslashes(utf8_decode($_POST['texte']));
	$urlvideo = utf8_decode($_POST['iframe']);
	if(!strpos($urlvideo, "iframe")){
		$video = new videoPlatform();
		$iframe = $video->share($urlvideo,535,325);
		$idvideo = $video->getID();
		$plateforme = $video->getPlatform();
	}
	//
	$jour_debut = $_POST['jour_debut'];
	$mois_debut = $_POST['mois_debut'];
	$annee_debut = $_POST['annee_debut'];
	$debut = $annee_debut.'-'.$mois_debut.'-'.$jour_debut;
	//
	$jour_fin = $_POST['jour_fin'];
	$mois_fin = $_POST['mois_fin'];
	$annee_fin = $_POST['annee_fin'];
	$fin = $annee_fin.'-'.$mois_fin.'-'.$jour_fin;
	
	//update type_artiste			
	$champs = array('id_album','texte_top_semaine','date_debut_top_semaine','date_fin_top_semaine','iframe_top_semaine','url_iframe_top_semaine','id_iframe','plateforme_top_semaine');
	$values = array($album,$texte,$debut,$fin,$iframe,$urlvideo,$idvideo,$plateforme);
	$sql->update('top_semaine',$champs,$values,"id_top_semaine='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='top_semaine-".$id.".php';</script>";	
	}
				
}

//============== PHOTOS =================//

function FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','gif','png','mp3','bmp','swf','flv','mpeg','jpeg'), $max_file_size=1048576, $upload_dir="", $callbackpage=''){
	
  if(!is_numeric($max_file_size)){
    $max_file_size = 1048576;
  }
 
  $max_file_size_Mo = $max_file_size/1048576;
  if(!isset($_POST['submitted'])){
	  
    $form = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
    <input type="hidden" name="submitted" value="TRUE" id="'.time().'">
    <input type="hidden" name="MAX_FILE_SIZE" value="'.$max_file_size.'">';
    for($x=0;$x<$num_of_uploads;$x++){
      $form .=  '<input type="file" name="file[]"><font color="red">*</font><br /><br />';
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
    $form .= '<footer><input type="submit" value="Envoyer"></footer></form>';
    echo $form;
	
	
	
  }else{ 
  
		if(!file_exists('../'.$upload_dir)){
			mkdir('../'.$upload_dir);	
		} 
		$sql = new sql();
		
		foreach($_FILES['file']['error'] as $key => $value){
			if($_FILES['file']['name'][$key]!=""){
				if($value==UPLOAD_ERR_OK){
					$origfilename = $_FILES['file']['name'][$key];
					$origfiletmpname = $_FILES['file']['tmp_name'][$key];
					//
					$txt = new texte();
					$filename = $txt ->cleanFile($origfilename);
					$filenameext = $txt->getExtension();
					//
					$filename = 'ts-'.$_SESSION['id'].'-'.$filename;
					$file_ext_allow = FALSE;
					//par mesure de securité on suppose l'extenion du fichier fausse
					//verifions si notre fichier fait partie des types autorisés
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
					$file_ext_allow = TRUE;
					}
					if($file_ext_allow){
						if($_FILES['file']['size'][$key]<$max_file_size){
							if(move_uploaded_file($origfiletmpname,'../'.$upload_dir.$filename)){
								
								
								$champs = array('photo_top_semaine');
								$values = array(utf8_decode($upload_dir.$filename));
								$sql->update('top_semaine',$champs,$values,'id_top_semaine='.$_SESSION['id']);
								//echo $sql->getQuery();
								$sql->execute();
								
							}else{
								echo('Une erreur est survenue lors du transfert de '.'<strong>'.$origfilename.'</strong><br />');
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
<div class="titre">MODIFIER Clip / album de la semaine</div>	
	<?php 
	//
	
	$sql->select('top_semaine',"id_top_semaine='".$id."'","*, DAY(date_debut_top_semaine) AS jour_debut, MONTH(date_debut_top_semaine) AS mois_debut, YEAR(date_debut_top_semaine) AS annee_debut, DAY(date_fin_top_semaine) AS jour_fin, MONTH(date_fin_top_semaine) AS mois_fin, YEAR(date_fin_top_semaine) AS annee_fin");
	//echo $sql->getQuery();
	$sql->execute();
	$res = $sql->result();
	//
	$id_album = $res['id_album'];
	$texte = utf8_encode($res['texte_top_semaine']);
	$iframe = utf8_encode($res['iframe_top_semaine']);
	$urlvideo = utf8_encode($res['url_iframe_top_semaine']);
	
	//
	$photo = utf8_encode($res['photo_top_semaine']);
	//
	$jour_debut = $res['jour_debut'];
	$mois_debut = $res['mois_debut'];
	$annee_debut = $res['annee_debut'];
	//
	$jour_fin = $res['jour_fin'];
	$mois_fin = $res['mois_fin'];
	$annee_fin = $res['annee_fin'];
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
             
        </header>
        
        <span class='champs'><strong>Date de début :</strong><br />
        	
             <select name="jour_debut" >
                  <?php
                        for($i=1;$i<=31;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$jour_debut){ echo "selected"; }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$jour_debut){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="mois_debut" >
                  <?php
                        for($i=1;$i<=12;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$mois_debut){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$mois_debut){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="annee_debut">
                  <?php
                        
                        for($i=1960;$i<=date('Y')+1;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$annee_debut){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
        
        </span>
        
        <span class='champs'><strong>Date de fin :</strong><br />
        	
             <select name="jour_fin" >
                  <?php
                        for($i=1;$i<=31;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$jour_fin){ echo "selected"; }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$jour_fin){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="mois_fin">
                  <?php
                        for($i=1;$i<=12;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$mois_fin){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$mois_fin){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="annee_fin">
                  <?php
                        
                        for($i=1960;$i<=date('Y')+1;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$annee_fin){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
        
        </span>
        
        <span class='champs'><strong>Album :</strong><br />
        	<select name="album">
            	<option value='0'>---</option>
            	<?php 
					$sql2->select("album INNER JOIN artiste ON artiste.id_artiste=album.id_artiste","","*","ORDER BY titre,nom_artiste");
					$sql2->execute();
					while($res2 = $sql2->result()){
						
						$id_album2 = $res2['id_album'];
						$titre2 = stripslashes(utf8_encode($res2['titre']));
						$nom_artiste2 = stripslashes(utf8_encode($res2['nom_artiste']));
						
				?>
                <option value="<?php echo $id_album2; ?>" <?php if($id_album==$id_album2) echo "SELECTED"?> ><?php echo $titre2.' - ('.$nom_artiste2.')'; ?></option>
                <?php	
					}
				?>
            </select></span>
        
        <span class='champs'><strong>Texte :</strong><br /><textarea name="texte" class="tinymce"><?php echo $texte; ?></textarea></span>
        
        <span class='champs'><strong>URL vidéo :</strong><br /><input type="text" name="iframe" value="<?php echo $urlvideo; ?>" /></span>
        
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
   
    
    <article>
    	<header>
        IMAGE
        </header> 
        <?php 
			if($photo==''){
		?>       
        <span class='champs'>
        <?php FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'), $max_file_size=4194304, $upload_dir='media/',$callbackpage='top_semaine-'.$id.'.php'); ?>
        </span>
        <?php
			}else{
		?>        	
            <span class="media">
            <div class="photo" style="background-image:url(../<?php echo $photo ?>);"><a href="top_semaine-<?php echo $id; ?>.php?idphoto=<?php echo $id; ?>&path=../<?php echo $photo; ?>"><div class="close"></div></a></div>
            </span>
            <div class="clear"></div>
        <?php
			}
		?>
    </article>
   
</div>





