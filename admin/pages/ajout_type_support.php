<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	
	//insert type_support			
	$champs = array('nom_type_support');
	$values = array($nom);
	$sql->insert('type_support',$champs,$values);
	//
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_support.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter type support</div>	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" /></span>
       
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
</div>