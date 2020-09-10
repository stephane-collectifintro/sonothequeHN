<?php

$sql = new sql();

//- - - - - - - - - - -  //
//- - - - ALBUM - - - -  //
//- - - - - - - - - - -  //

$sql->select('radio',"id_radio='".$id."'");
$sql->execute();
$res = $sql->result();
//
$titre = utf8_encode($res['titre_radio']);
$description = $res['descriptif_radio'];
$image = $res['image_radio'];
$online = $res['online_radio'];
$modified = date("Y-m-d H:i:s");

//
//============== INFOS =================//
//

if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$titre = addslashes(utf8_decode($_POST['titre']));
	$description = addslashes($_POST['description']);
	$online = $_POST['online'];
	//
	$sql->setQuery("UPDATE radio SET titre_radio='".$titre."', descriptif_radio='".$description."', online_radio='".$online."', modified_radio='".$modified."' WHERE id_radio='".$id."'");
	if($sql->execute()){
		echo "<script>window.location.href='radio-".$id.".php';</script>";	
	}
				
}

//
//============== SUPPR JACKETTE =================//
//
if(isset($_GET['img']) && is_readable($_GET['img'])){
	//
	unlink($_GET['img']);
	//
	$sql->setQuery("UPDATE radio SET image_radio='', modified_radio='".$modified."' WHERE id_radio=".$id);
	if($sql->execute()){
		echo "<script>window.location.href='radio-".$id.".php';</script>";	
	}
	
		
}


//
//============== SUPPR TRACKS =================//
//
if(isset($_GET['supprtrack'])){
	
	
	$sql->setQuery("DELETE FROM radio_titre WHERE id_radio=".$id." AND id_chanson=".$_GET['supprtrack']);
	if($sql->execute()){
		$sql->setQuery("UPDATE radio SET modified_radio='".$modified."' WHERE id_radio=".$id);
		if($sql->execute()){		
			echo "<script>window.location.href='radio-".$id.".php';</script>";	
		}		
	}
			
}





//============== PHOTOS =================//

function FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','gif','png','mp3','bmp','swf','flv','mpeg','jpeg'), $max_file_size=1048576, $upload_dir="", $callbackpage=""){
	
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
    $form .= '<br><font color="red">*</font>Type(s) de fichiers autorisés : ';
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
					$filename = $_SESSION['id'].'-radio-'.$filename;
					$file_ext_allow = FALSE;
					//par mesure de securité on suppose l'extenion du fichier fausse
					//verifions si notre fichier fait partie des types autorisés
					if(false !== ($iClef = array_search($filenameext, $file_types_array))) {
					$file_ext_allow = TRUE;
					}
					
					if($file_ext_allow){
						if($_FILES['file']['size'][$key]<$max_file_size){
							
													
							if(move_uploaded_file($_FILES['file']['tmp_name'][$key],'../'.$upload_dir.$filename)){
																		
								$sql->setQuery("UPDATE radio SET image_radio='".$upload_dir.$filename."', modified_radio='".date('Y-m-d H:i:s')."' WHERE id_radio=".$_SESSION['id']);
								$sql->execute();

								imagethumb('../'.$upload_dir.$filename,'../'.$upload_dir.$filename,300);
								
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
		
		if($callbackpage!=''):

			echo '<script>window.location.href="'.$callbackpage.'";</script>';

		endif;
	}
}
//============== FIN PHOTOS =================//



//============== TITRES =================//

if (isset($_POST['track'])):
	$track = $_POST['track'];
	foreach ($track as $key => $value):

		$sql = new sql();
		$sql->setQuery('INSERT INTO radio_titre SET id_radio='.$id.', id_chanson='.$value);
		//print $sql->getQuery();
		$sql->execute();
	
	endforeach;

	$sql->setQuery("UPDATE radio SET modified_radio='".$modified."' WHERE id_radio=".$id);
	if($sql->execute()){		
		print "<script>window.location.href='radio-".$id.".php';</script>";	
	}	

endif;

//============== FIN TITRES =================//


?>

<div id="content">
<div class="titre">MODIFIER RADIO</div>	
	<?php 
	
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>

        <header>
        
        	
        
          <input type="checkbox" name="online" value="1" <?php if ($online): ?>checked<?php endif ?> > En ligne  
        </header>
        
        
        <span class='champs'><strong>Titre :</strong><br /><input type="text" name="titre" value="<?php print $titre;  ?>" /></span>
                         
        <span class='champs'><strong>Description :</strong><br />
        	<textarea name="description" class="tinymce"><?php echo $description; ?></textarea>
        </span>
        
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
    
    
    
    
    
    <article>
    
    	<header>
        IMAGE
        </header>
        
		<?php if (!empty($image) && is_readable('../'.$image)): ?>
			
		<span class="media">
        	<div class="photo" style="background-image:url(../<?php echo $image; ?>);"><a href="radio-<?php echo $id; ?>.php?img=../<?php echo $image; ?>"><div class="close"></div></a></div>
        </span>
        
        <?php else: ?>
        
        <span class='champs'>
        <?php FILE_UPLOADER($num_of_uploads=1, $file_types_array=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'), $max_file_size=4194304, $upload_dir='media/',$callbackpage='radio-'.$id.'.php'); ?>
        </span>

        <?php endif; ?>
        
        <div class="clear"></div>
  
    </article>



    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <article>
    
    	<header>
        TRACKS
        </header>
        
        
        <span class='champs' id="selection">
        	
        	<select name="artiste" >
                <option value="0">- Choisir un artiste -</option>
               
                <?php

                $sql = new sql();
                $sql->select("artiste",'','','ORDER BY nom_artiste');
                $sql->execute();
                while($res = $sql->result()):
                ?>

                <option value="<?php echo $res['id_artiste']; ?>"><?php echo utf8_encode(stripslashes($res['nom_artiste'])); ?></option>
            
                <?php endwhile; ?>
        	</select>
        	<a href="" class="lien_next" id="submit_artiste"></a>
			
			<script type="text/javascript">
	        	$(function() {
				  
	        		$('#submit_artiste').click(function(){
	        			//
	        			$.ajax({
					       url : 'views/get_select_album.php',
					       type : 'POST',
					       data : 'id_artiste=' + $('#selection select').val(),
					       success : function(msg){ // code_html contient le HTML renvoyé

					          $("#selection").html(msg);
					       }
					    });
	        			//
	        			return false;
	        		});

				});
	        </script>

        </span>
		
		<span class="champs">
        <ul class="column">
        <?php 

        $sql = new sql();
        $sql->setQuery("SELECT * 
						FROM `radio_titre` 
						INNER JOIN chanson ON chanson.id_chanson=radio_titre.id_chanson
						INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
						INNER JOIN album ON chanson.id_album = album.id_album
						INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
						WHERE id_radio=".$id." ORDER BY ordre_radio_titre ASC");

        //print $sql->getQuery();
        $sql->execute();
        while($res = $sql->result()):
			
			$piste_chanson = $res['piste'];
			$duree_chanson = $res['duree'];
			$nom_chanson = utf8_encode($res['nom']);
			$id_pj = $res['id_pj'];
			$path = $res['url_pj'];
			$nom_fichier = $res['nom_pj'];
			$id_chanson = $res['id_chanson'];
			$artiste = $res['nom_artiste'];
			$album = $res['titre'];
						
		?>
        	<style type="text/css">
				
				.column span{
					display: inline-block;
					padding: 0 5px;
					height: 33px;
					vertical-align: bottom;
					line-height: 33px;
				}

				.column span:first-child{
					
					line-height: 24px;
				}

				.column span:nth-child(3){
					
					width:auto;
				}

        	</style>
        
			<li id="track_<?php print $id_chanson; ?>">
				<span><i class="move" title="Déplacez-moi !"></i></span>
            	<span><audio controls style="width:45px" id="player<?php echo $id_pj; ?>" ><source src="<?php echo $HOST.'/musik_sonotk/'.$path; ?>" type="audio/mpeg"></audio></span>
        		<span><?php echo $nom_chanson.' <i>('.$artiste.'/'.$album.')</i>'; ?></span>
		        <span><a href="radio-<?php echo $id; ?>.php?supprtrack=<?php echo $id_chanson; ?>"><img src="images/bin.png" height="16" /></a></span>
        	</li>
        
        
        <?php endwhile; ?>
        </ul>
        </span>


        
    </article>
    </form>

   
   
</div>





