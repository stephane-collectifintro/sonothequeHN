
<?php
$sql = new sql();
$sql2 = new sql();

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
	$sql->insert('interview',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='interview-".$sql->insertID().".php';</script>";	
	}
				
}

?>

<div id="content">
<div class="titre">ajouter interview</div>	
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
                <option value="<?php echo $id_artiste2; ?>" ><?php echo $nom_artiste2; ?></option>
                <?php	
					}
				?>
            </select></span>
        
        <span class='champs'><strong>Texte :</strong><br /><textarea name="texte" class="tinymce"></textarea></span>
                
        <footer><input type="submit" value="ajouter"/></footer>
        
    </article>
    </form>
   
     
</div>





