<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$description = addslashes(utf8_decode($_POST['description']));
	
	
	//update type_type_structure			
	$champs = array('nom_type_structure','description_type_structure');
	$values = array($nom,$description);
	$sql->update('type_structure',$champs,$values,"id_type_structure='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_structure.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">MODIFIER type structure</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('type_structure',"id_type_structure='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_type_structure']);
	$description = utf8_encode($res['description_type_structure']);
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