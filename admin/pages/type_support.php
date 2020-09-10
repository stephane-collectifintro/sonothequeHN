<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	
	
	//update type_support			
	$champs = array('nom_type_support');
	$values = array($nom);
	$sql->update('type_support',$champs,$values,"id_type_support='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_support.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">MODIFIER type_support</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('type_support',"id_type_support='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_type_support']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
               
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
</div>