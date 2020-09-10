<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$description = addslashes(utf8_decode($_POST['description']));
	
	//insert type_style			
	$champs = array('nom','description');
	$values = array($nom,$description);
	$sql->insert('type_style',$champs,$values);
	//
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_style.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter type style</div>	
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