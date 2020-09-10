<?php
$sql = new sql();

//============== DONNEES =================//
if((isset($_POST['nom']) && $_POST['nom']!="") || (isset($_POST['prenom']) && $_POST['prenom']!="")){
	//
	$nom = addslashes(utf8_decode($_POST['nom']));
	$prenom = addslashes(utf8_decode($_POST['prenom']));
	$adresse = addslashes(utf8_decode($_POST['adresse']));
	$cp = utf8_decode($_POST['cp']);
	$ville = addslashes(utf8_decode($_POST['ville']));
	$tel = utf8_decode($_POST['tel']);
	$mail = utf8_decode($_POST['mail']);
	
	//update type_personne			
	$champs = array('nom_personne','prenom_personne','adresse_personne','cp_personne','ville_personne','tel_personne','courriel_personne');
	$values = array($nom,$prenom,$adresse,$cp,$ville,$tel,$mail);
	$sql->insert('personne',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_personne.php';</script>";	
	}
				
}
//============== FIN DONNEES =================//

?>
<div id="content">
<div class="titre">ajouter personne</div>	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
               
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" /></span>
        
        <span class='champs'><strong>Prenom :</strong><br /><input type="text" name="prenom" /></span>
        
        <span class='champs'><strong>Adresse :</strong><br /><input type="text" name="adresse" /></span>
        
        <span class='champs'><strong>Code Postal :</strong><br /><input type="text" name="cp" /></span>
        
        <span class='champs'><strong>Ville :</strong><br /><input type="text" name="ville" /></span>
        
        <span class='champs'><strong>Téléphone :</strong><br /><input type="text" name="tel" /></span>
        
        <span class='champs'><strong>Mail :</strong><br /><input type="text" name="mail" /></span>
       
        <footer><input type="submit" value="Ajouter"/></footer>
        
    </article>
    </form>
</div>