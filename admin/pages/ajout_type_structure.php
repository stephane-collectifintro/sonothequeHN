<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$description = addslashes(utf8_decode($_POST['description']));
	
	//insert type_structure			
	$champs = array('nom_type_structure','description_type_structure');
	$values = array($nom,$description);
	$sql->insert('type_structure',$champs,$values);
	//
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_structure.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter type structure</div>	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><input type="text" name="description" /></span>
       
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
</div>