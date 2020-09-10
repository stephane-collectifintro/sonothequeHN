
<?php
$sql = new sql();
$sql2 = new sql();

if(isset($_GET['idphoto']) && $_GET['idphoto']!=""){
	unlink($_GET['path']);

	$champs = array('photo_interview');
	$values = array('');
	$sql->update('interview',$champs,$values,"id_interview='".$id."'");
	if($sql->execute()){
		echo "<script>window.location.href='interview-".$id.".php';</script>";
	}


}

if(isset($_POST['align'])){
	//update alignement
	$align = addslashes(utf8_decode($_POST['align']));
	//
	$champs = array('align_photo_interview');
	$values = array($align);
	$sql->update('interview',$champs,$values,'id_interview='.$id);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='interview-".$id.".php';</script>";
	}
}
//============== INFOS =================//
if((isset($_POST['artiste']) && $_POST['artiste']!==0)){
	//
	$artiste = utf8_decode($_POST['artiste']);
	$texte = addslashes(utf8_decode($_POST['texte']));
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
	$champs = array('id_artiste','texte_interview','date_debut_interview','date_fin_interview');
	$values = array($artiste,$texte,$debut,$fin);
	$sql->update('interview',$champs,$values,'id_interview='.$id);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='interview-".$id.".php';</script>";
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
      $form .=  '<input type="file" onchange="readURL(this);" name="file[]" accept=".jpeg,.jpg,.JPEG,.JPG"><font color="red">*</font><br /><br />';
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
					$filename = 'interview-'.$_SESSION['id'].'-'.$filename;
					$file_ext_allow = FALSE;
					//par mesure de securité on suppose l'extenion du fichier fausse
					//verifions si notre fichier fait partie des types autorisés
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
					$file_ext_allow = TRUE;
					}
					if($file_ext_allow){
						if($_FILES['file']['size'][$key]<$max_file_size){
							if(move_uploaded_file($origfiletmpname,'../'.$upload_dir.$filename)){


								$champs = array('photo_interview','align_photo_interview');
								$values = array(utf8_decode($upload_dir.$filename),'center');
								$sql->update('interview',$champs,$values,'id_interview='.$_SESSION['id']);
								//echo $sql->getQuery();
								$sql->execute();

                                imagethumb('../'.$upload_dir.$filename,'../'.$upload_dir.$filename,700);

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
<div class="titre">MODIFIER interview</div>
	<?php
	//

	$sql->select('interview',"id_interview=".$id,"*, DAY(date_debut_interview) AS jour_debut, MONTH(date_debut_interview) AS mois_debut, YEAR(date_debut_interview) AS annee_debut, DAY(date_fin_interview) AS jour_fin, MONTH(date_fin_interview) AS mois_fin, YEAR(date_fin_interview) AS annee_fin");
	//echo $sql->getQuery();
	$sql->execute();
	$res = $sql->result();
	//
	$id_artiste = $res['id_artiste'];
	$texte = utf8_encode($res['texte_interview']);
	$photo = utf8_encode($res['photo_interview']);
	$align_photo = utf8_encode($res['align_photo_interview']);
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

        <span class='champs'><strong>Artiste :</strong><br />
        	<select name="artiste">
            	<option value='0'>---</option>
            	<?php
					$sql2->select("artiste","","*","ORDER BY nom_artiste");
					$sql2->execute();
					while($res2 = $sql2->result()){

						$id_artiste2 = $res2['id_artiste'];
						$nom_artiste2 = stripslashes(utf8_encode($res2['nom_artiste']));

				?>
                <option value="<?php echo $id_artiste2; ?>" <?php if($id_artiste==$id_artiste2) echo "SELECTED"?> ><?php echo $nom_artiste2; ?></option>
                <?php
					}
				?>
            </select></span>

        <span class='champs'><strong>Texte :</strong><br /><textarea name="texte" class="tinymce"><?php echo $texte; ?></textarea></span>

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
							<?php FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg','JPG','JPEG'), $max_file_size=4194304, $upload_dir='media/',$callbackpage='interview-'.$id.'.php'); ?>
							</span>
							<progress id="thebar" value="0" style="width: 100%; z-index: 100; margin-top: 20%;" max="0"></progress>
							<button id="crop_button" class="btn btn-secondary hidden">Crop</button>
							<button id="send_button" class="btn btn-success hidden">Valider</button>
							<button id="bt_close" type="button" class="btn btn-default" >Close</button>
						</div>
					</div>
				</div>
				</div>
        <?php
			}else{
		?>
            <span class="media">
            <div class="photo" style="background-image:url(../<?php echo $photo ?>);"><a href="interview-<?php echo $id; ?>.php?idphoto=<?php echo $id; ?>&path=../<?php echo $photo; ?>"><div class="close"></div></a></div>
            </span>
            <div class="clear"></div>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            	<span class='champs'><strong>Alignement :</strong><br />
                <input type="radio" name="align" value="left" <?php if($align_photo=="left") echo "checked"; ?> /> Gauche &nbsp;&nbsp;&nbsp;
                <input type="radio" name="align" value="center" <?php if($align_photo=="center") echo "checked"; ?> /> Centre &nbsp;&nbsp;&nbsp;
                <input type="radio" name="align" value="right" <?php if($align_photo=="right") echo "checked"; ?> /> Droite   &nbsp;&nbsp;&nbsp;<input type="submit"/></span> </form>
            <div class="clear"></div>
        <?php
			}
		?>
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
						var formData = new FormData();
						 formData.append('croppedImage', blob);
						 formData.append('origfilename', $('input[type=file]')[0].files[0]);
						 // Use `jQuery.ajax` method
						 $.ajax('/admin/views/upload_interview.php', {
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
