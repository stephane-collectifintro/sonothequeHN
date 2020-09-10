<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$description = addslashes(utf8_decode($_POST['description']));
	$type = utf8_decode($_POST['type']);
	//update type_style			
	$champs = array('nom_type_role','description_role','type_type_role');
	$values = array($nom,$description,$type);
	$sql->insert('type_role',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_role_album.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter rôle album</div>	
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><input type="text" name="description" /></span>
        
       	<span class='champs'>
        	<strong>Type :</strong><br />
        	<select name="type">
            	<option value="musicien">Musicien</option>
                <option value="technicien">Technicien</option>
            </select>
        </span>
        
        <footer><input type="submit" value="ajouter"/></footer>
        
    </article>
    </form>
</div>