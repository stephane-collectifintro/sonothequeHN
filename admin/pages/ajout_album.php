
<?php

$sql = new sql();

//============== INFOS =================//
if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$artiste = $_POST['artiste'];
	$titre = addslashes($_POST['titre']);
	$style = $_POST['style'];
	$annee = $_POST['annee'];
	$support = $_POST['support'];
	$droit = $_POST['droit'];
	$commentaire = addslashes($_POST['commentaire']);
	
	$texte = new texte();
	$stockage = $texte->clean($_POST['titre']);
	
	//update type_album			
	$champs = array('id_artiste','id_type_style','titre','annee_sortie','support','gestion_droit','commentaire_album','nom_stockage','date_insertion');
	$values = array($artiste,$style,$titre,$annee,$support,$droit,$commentaire,$stockage,date('Y-m-d'));
	$sql->insert('album',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
	
		$sql->select('artiste','id_artiste='.$artiste);
		$sql->execute();
		$res = $sql->result();
		$stockage_artiste = $res['nom_stockage'];
		mkdir('../musik_sonotk/'.$stockage_artiste.'/'.$stockage);
		
		echo "<script>window.location.href='album-".$sql->insertID().".php';</script>";	
	}
				
}


?>

<div id="content">
<div class="titre">ajouter album</div>	
	
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
        
        <span class='champs'><strong>Titre :</strong><br /><input type="text" name="titre" value="<?php echo stripslashes($titre);  ?>" /></span>
        
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
					if($support==$res2['nom_type_support']){
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
            <option value="2" <?php if($droit=="Autorisation de diffusion"){ echo "selected"; } ?> >Autorisation de diffusion</option>    
        	<option value="1" <?php if($droit=="Adhérent SACEM"){ echo "selected"; } ?> >Adhérent SACEM</option>
                  
        </select>
         </span>
        <span class='champs'><strong>Commentaire :</strong><br />
        	<textarea name="commentaire"><?php echo $commentaire; ?></textarea>
        </span>
        
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
    
    
   
</div>





