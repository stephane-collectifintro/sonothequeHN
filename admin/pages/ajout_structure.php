<?php
$sql = new sql();

//============== DONNEES =================//
if(isset($_POST['nom']) && $_POST['nom']!=""){
	//
	$nom = addslashes(utf8_encode($_POST['nom']));
	$type = utf8_encode($_POST['type']);
	$mail = utf8_encode($_POST['mail']);
	$site = utf8_encode($_POSTs['site']);
	$adresse = addslashes(utf8_encode($_POST['adresse']));
	$cp = utf8_encode($_POST['cp']);
	$ville = addslashes(utf8_encode($_POST['ville']));
	$tel = utf8_encode($_POST['tel']);
	$description = addslashes(utf8_encode($_POST['description']));
	
	//update type_structure			
	$champs = array('nom_structure','id_type_structure','courriel_structure','site_web','adresse_structure','cp','ville','telephone_structure','description_structure');
	$values = array($nom,$type,$mail,$site,$adresse,$cp,$ville,$tel,$description);
	$sql->insert('structure_sonotk',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_structure.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter type structure</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('structure_sonotk',"id_structure='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_structure']);
	$mail = utf8_encode($res['courriel_structure']);
	$site = utf8_encode($res['site_web']);
	$adresse = utf8_encode($res['adresse_structure']);
	$cp = utf8_encode($res['cp']);
	$ville = utf8_encode($res['ville']);
	$tel = utf8_encode($res['telephone_structure']);
	$description = utf8_encode($res['description_structure']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
          <strong>Type :</strong>
        <select name="type">
        <?php
			$sql2 = new sql();
			$sql2->select('type_structure',"","*","ORDER BY nom_type_structure");
			$sql2->execute();
			//
			while($res2 = $sql2->result()){
				echo "<option value='".$res2['id_type_structure']."'>".utf8_encode($res2['nom_type_structure'])."</option>";
			}
		?>
        </select>
        <a href="ajout_type_structure.php" class="lien_annexe"></a>
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" /></span>
        
        <span class='champs'><strong>Mail :</strong><br /><input type="text" name="mail" /></span>
        
        <span class='champs'><strong>Site web :</strong><br /><input type="text" name="site" /></span>
        
        <span class='champs'><strong>Adresse :</strong><br /><input type="text" name="adresse" /></span>
        
        <span class='champs'><strong>Code Postal :</strong><br /><input type="text" name="cp" /></span>
        
        <span class='champs'><strong>Ville :</strong><br /><input type="text" name="ville" /></span>
        
        <span class='champs'><strong>Téléphone :</strong><br /><input type="text" name="tel" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><textarea name="description" class="tinymce" ></textarea></span>
       
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
</div>