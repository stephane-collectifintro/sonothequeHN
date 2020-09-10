<?php

$sql = new sql();

//- - - - - - - - - - -  //
//- - - - actu - - - -  //
//- - - - - - - - - - -  //

$sql->select("actualite",'id_actualite='.$id);
$sql->execute();
$res = $sql->result();
//
$titre_actu = utf8_encode($res['titre_actualite']);
$texte_actu = utf8_encode($res['texte_actualite']);
$date_actu = explode('-',substr($res['date_actualite'], 0, 10));
$image_actu = utf8_encode($res['photo_actualite']);
//
$jour = $date_actu[2];
$mois = $date_actu[1];
$annee = $date_actu[0];
//
//============== SUPPR JACKETTE =================//
//
if(isset($_GET['idphoto']) && $_GET['idphoto']!=""){
	if(file_exists($_GET['path'])){
		unlink($_GET['path']);
	}
	$champs = array('photo_actualite');
	$values = array('');
	$sql->update('actualite',$champs,$values,'id_actualite='.$_GET['idphoto']);
	if($sql->execute()){
		echo "<script>window.location.href='actualite-".$id.".php';</script>";
	}
}

//============== INFOS =================//
//
if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$titre = addslashes(utf8_decode($_POST['titre']));
	$date = $_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
	$texte = addslashes(utf8_decode($_POST['texte']));
	//
	$champs = array('titre_actualite','texte_actualite','date_actualite');
	$values = array($titre,$texte,$date);
	$sql->update('actualite',$champs,$values,"id_actualite='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='actualite-".$id.".php';</script>";
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
      $form .=  '<input type="file" onchange="readURL(this);" name="file[]" accept=".jpeg,.jpg,.JPEG,.JPG><font color="red">*</font><br /><br />';
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
    $form .= '</form>';
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
					$filename = $_SESSION['id'].'-actualite-'.$filename;


					$file_ext_allow = FALSE;
					//par mesure de securité on suppose l'extenion du fichier fausse
					//verifions si notre fichier fait partie des types autorisés
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
					$file_ext_allow = TRUE;
					}

					if($file_ext_allow){
						if($_FILES['file']['size'][$key]<$max_file_size){
							if(move_uploaded_file($_FILES['file']['tmp_name'][$key],'../'.$upload_dir.$filename)){

								$champs = array('photo_actualite');
								$values = array($upload_dir.$filename);
								$sql->update('actualite',$champs,$values,'id_actualite='.$_SESSION['id']);

								$sql->execute();

                imagethumb('../'.$upload_dir.$filename,'../'.$upload_dir.$filename,700);

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





?>

<div id="content">
<div class="titre">MODIFIER actualité</div>
	<?php

	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <article>
        <header>
           <select name="jour" >
                  <?php
                        for($i=1;$i<=31;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";
                            }
                            if($i==$jour){ echo "selected"; }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$jour){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php
                        }
                    ?>
                </select>
                <select name="mois" >
                  <?php
                        for($i=1;$i<=12;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";
                            }
                            if($i==$mois){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$mois){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php
                        }
                    ?>
                </select>
                <select name="annee">
                  <?php

                        for($i=date('Y')-1;$i<=date('Y');$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$annee){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php
                        }
                    ?>
                </select>
        </header>

        <span class='champs'><strong>Titre :</strong><br /><input type="text" name="titre" value="<?php echo stripslashes($titre_actu);  ?>" /></span>

        <span class='champs'><strong>Texte :</strong><br />
        	<textarea name="texte"  class="tinymce"><?php echo $texte_actu; ?></textarea>
        </span>

        <footer><input type="submit" value="Modifier"/></footer>

    </article>
    </form>





    <article>
    	<header>
        PHOTO
        </header>

        <?php
		if($image_actu!=''){
		?>
        <span class="media">
            <div class="photo" style="background-image:url(<?php echo $HOST; ?>/<?php echo $image_actu; ?>);"><a href="actualite-<?php echo $id; ?>.php?idphoto=<?php echo $id; ?>&path=../<?php echo $image_actu; ?>"><div class="close"></div></a></div>
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
								<?php FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg','JPG','JPEG'), $max_file_size=4194304, $upload_dir='media/',$callbackpage='actualite-'.$id.'.php'); ?>
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
						 $.ajax('/admin/views/upload_actu.php', {
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
