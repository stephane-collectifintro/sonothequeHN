
<?php
$sql = new sql();
$sql2 = new sql();

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
	$champs = array('id_album','texte_top_semaine','date_debut_top_semaine','date_fin_top_semaine','url_iframe_top_semaine','iframe_top_semaine','id_iframe','plateforme_top_semaine');
	$values = array($album,$texte,$debut,$fin,$urlvideo,$iframe,$idvideo,$plateforme);
	$sql->insert('top_semaine',$champs,$values);
	echo $sql->getQuery();
	if($sql->execute()){
		
		echo "<script>window.location.href='top_semaine-".$sql->insertID().".php';</script>";	
	}
				
}

?>

<div id="content">
<div class="titre">Ajouter Clip / album de la semaine</div>	
	<?php 
	//
	$date = date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')-date('N')+1, date('Y')));
	$date = explode('-',$date);
	$jour_debut = $date[0];
	$mois_debut = $date[1];
	$annee_debut = $date[2];
	
	$date = date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')+6-date('N')+1, date('Y')));
	$date = explode('-',$date);
	$jour_fin = $date[0];
	$mois_fin = $date[1];
	$annee_fin = $date[2];
	
	
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
                <option value="<?php echo $id_album2; ?>" ><?php echo $titre2.' - ('.$nom_artiste2.')'; ?></option>
                <?php	
					}
				?>
            </select></span>
        
        <span class='champs'><strong>Texte :</strong><br /><textarea name="texte" class="tinymce"></textarea></span>
        
        <span class='champs'><strong>iFrame :</strong><br /><input type="text" name="iframe" /></span>
        
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
   
     
</div>





