<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$description = addslashes(utf8_decode($_POST['description']));
	
	//update type_style			
	$champs = array('nom_type_role_structure_album','description_type_role_structure_album');
	$values = array($nom,$description);
	$sql->update('type_role_structure_album',$champs,$values,"id_type_role_structure_album='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_role_structure_album.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">MODIFIER rôle structure</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('type_role_structure_album',"id_type_role_structure_album='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_type_role_structure_album']);
	$description = utf8_encode($res['description_type_role_structure_album']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><input type="text" name="description" value="<?php echo $description; ?>" /></span>
       
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
</div>