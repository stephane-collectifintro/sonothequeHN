
<?php
$sql = new sql();

//============== INFOS =================//
if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$titre = addslashes(utf8_decode($_POST['titre']));
	$description = addslashes(utf8_decode($_POST['bio']));
	$created = date("Y-m-d H:i:s");
    //
	$sql->select('radio','titre_radio="'.$titre.'"');
	$sql->execute();
	
	if($sql->result()){
		echo '<script>alert("Cette radio semble déjà être enregistrée")</script>';
	}else{
		//update type_artiste			
		
		$sql->setQuery("INSERT INTO radio SET titre_radio='".$titre."', descriptif_radio='".$description."', created_radio='".$created."', modified_radio='".$created."'");
		$nextID = $sql->nextID('radio');
		//echo $sql->getQuery();
		if($sql->execute()){
			echo "<script>window.location.href='radio-".$nextID.".php';</script>";	
		}
	}			
}

?>

<div id="content">
<div class="titre">AJOUTER Radio</div>	
	
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
          INFORMATION     
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="titre" value="<?php echo $titre;  ?>" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><textarea name="bio" class="tinymce"><?php echo $bio; ?></textarea></span>
             
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
    
   

   
</div>





