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
	$sql->update('type_role',$champs,$values,"id_type_role='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_role_album.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">MODIFIER rôle album</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('type_role',"id_type_role='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_type_role']);
	$description = utf8_encode($res['description_role']);
	$type = utf8_encode($res['type_type_role']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><input type="text" name="description" value="<?php echo $description; ?>" /></span>
        
       	<span class='champs'>
        	<strong>Type :</strong><br />
        	<select name="type">
            	<option value="musicien" <?php if($type=="musicien") echo "selected"?>>Musicien</option>
                <option value="technicien" <?php if($type=="technicien") echo "selected"?>>Technicien</option>
            </select>
        </span>
        
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
</div>