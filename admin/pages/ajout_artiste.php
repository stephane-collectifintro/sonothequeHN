
<?php
$sql = new sql();

//============== INFOS =================//
if((isset($_POST['nom']) && $_POST['nom']!="")){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$bio = addslashes(utf8_decode($_POST['bio']));
	$ville = addslashes(utf8_decode($_POST['ville']));
	$site = utf8_decode($_POST['site']);
	$site2 = utf8_decode($_POST['site2']);
	
	$texte = new texte();
	$stockage = $texte->clean($_POST['nom']);
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
	//
	$sql->select('artiste','nom_artiste="'.$nom.'"');
	$sql->execute();
	
	if($sql->result()){
		echo '<script>alert("Cette artiste semble déjà être enregistré")</script>';
	}else{
		//update type_artiste			
		$champs = array('nom_artiste','bio_artiste','date_creation','date_fin','ville','url_site_web','url_site_web_2','nom_stockage');
		$values = array($nom,$bio,$debut,$fin,$ville,$site,$site2,$stockage);
		$sql->insert('artiste',$champs,$values);
		$nextID = $sql->nextID('artiste');
		echo $sql->getQuery();
		if($sql->execute()){
			mkdir('../musik_sonotk/'.$stockage);
			echo "<script>window.location.href='artiste-".$nextID.".php';</script>";	
		}
	}			
}

?>

<div id="content">
<div class="titre">AJOUTER artiste</div>	
	
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
          INFORMATION     
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
        
        <span class='champs'><strong>Biographie :</strong><br /><textarea name="bio" class="tinymce"><?php echo $bio; ?></textarea></span>
        
        <span class='champs'><strong>Date de création :</strong><br />
        	
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
                        
                        for($i=1960;$i<=date('Y');$i++){
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
                        
                        for($i=1960;$i<=date('Y');$i++){
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
        
        <span class='champs'><strong>Ville :</strong><br /><input type="text" name="ville" value="<?php echo $ville;  ?>" /></span>
        
        <span class='champs'><strong>Site web :</strong><br /><input type="text" name="site" value="<?php echo $site;  ?>" /></span>
        
        <span class='champs'><strong>Site web :</strong><br /><input type="text" name="site2" value="<?php echo $site2;  ?>" /></span>
             
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
    
   

   
</div>





