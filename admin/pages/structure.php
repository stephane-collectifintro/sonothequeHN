<?php
$sql = new sql();
//
//============== DONNEES =================//
//
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
	$sql->update('structure_sonotk',$champs,$values,"id_structure='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_structure.php';</script>";	
	}
				
}
//
//============== PERSONNE =================//
//
if((isset($_POST['personne']) && $_POST['personne']!==0) && (isset($_POST['role']) && $_POST['role']!==0)){
	//
	$personne = utf8_encode($_POST['personne']);
	$role = utf8_encode($_POST['role']);
	//		
	$champs = array('id_personne','id_structure','id_type_role_struct');
	$values = array($personne,$id,$role);
	$sql->insert('a_un_role_structure',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='structure-".$id.".php';</script>";	
	}
				
}
//
//============== SUPPR PERSONNE =================//
//
if(isset($_GET['arole']) && $_GET['arole']!=''){
	//
	$sql->delete('a_un_role_structure',"id_a_un_role_structure=".$_GET['arole']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='structure-".$id.".php';</script>";	
	}
				
}

//
//============== ALBUM =================//
//
if((isset($_POST['album']) && $_POST['album']!==0) && (isset($_POST['rolestructure']) && $_POST['rolestructure']!==0)){
	//
	$album = utf8_encode($_POST['album']);
	$role = utf8_encode($_POST['rolestructure']);
	//		
	$champs = array('id_album','id_structure','id_type_role_structure_album');
	$values = array($album,$id,$role);
	$sql->insert('structure_role_album',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='structure-".$id.".php';</script>";	
	}
				
}
//
//============== SUPPR ALBUM =================//
//
if(isset($_GET['arolestructure']) && $_GET['arolestructure']!=''){
	//
	$sql->delete('structure_role_album',"id_structure_role_album=".$_GET['arolestructure']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='structure-".$id.".php';</script>";	
	}
				
}



?>
<div id="content">
<div class="titre">MODIFIER structure</div>	
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
				if($res['id_type_structure']==$res2['id_type_structure']){
					$selected = "selected";	
				}else{
					$selected = "";	
				}
				echo "<option value='".$res2['id_type_structure']."' ".$selected.">".utf8_encode($res2['nom_type_structure'])."</option>";
			}
		?>
        </select>
        <a href="ajout_type_structure.php" class="lien_annexe"></a>
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
        
        <span class='champs'><strong>Mail :</strong><br /><input type="text" name="mail" value="<?php echo $mail;  ?>" /></span>
        
        <span class='champs'><strong>Site web :</strong><br /><input type="text" name="site" value="<?php echo $site;  ?>" /></span>
        
        <span class='champs'><strong>Adresse :</strong><br /><input type="text" name="adresse" value="<?php echo $adresse;  ?>" /></span>
        
        <span class='champs'><strong>Code Postal :</strong><br /><input type="text" name="cp" value="<?php echo $cp;  ?>" /></span>
        
        <span class='champs'><strong>Ville :</strong><br /><input type="text" name="ville" value="<?php echo $ville;  ?>" /></span>
        
        <span class='champs'><strong>Téléphone :</strong><br /><input type="text" name="tel" value="<?php echo $tel;  ?>" /></span>
        
        <span class='champs'><strong>Description :</strong><br /><textarea name="description" class="tinymce" ><?php echo $description; ?></textarea></span>
       
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
    
    
    <article>
    	<header>
        PERSONNES ASSOCIÉS
        </header>
        <span class="champs">
        <ul>
        <?php 
			$sql->select("personne INNER JOIN a_un_role_structure ON personne.id_personne = a_un_role_structure.id_personne INNER JOIN type_role_personne_structure ON type_role_personne_structure.id_type_role_personne_structure=a_un_role_structure.id_type_role_struct","id_structure=".$id,"","ORDER BY nom_personne, prenom_personne");
			//echo $sql->getQuery();
			$sql->execute();
			while($res = $sql->result()){
				
				$id_personne = $res['id_personne'];
				$prenom = utf8_encode($res['prenom_personne']);
				$nom = utf8_encode($res['nom_personne']);
				$nom_role = utf8_encode($res['nom_type_role_structure']);
				
				echo '<li><a href="structure-'.$id.'.php?arole='.$res['id_a_un_role_structure'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_personne.'.php">'.$nom.' '.$prenom.'</a></i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucune personne associé</i>";
			}
		?>
        </ul>
        
        </span>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
        <span class="champs">
        	Nom : 
        	<select name="personne">
            	<option value='0'>---</option>
            	<?php 
					$sql->select("personne","","","ORDER BY nom_personne, prenom_personne");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_personne = $res['id_personne'];
						$prenom = utf8_encode($res['prenom_personne']);
						$nom = utf8_encode($res['nom_personne']);
				?>
                <option value="<?php echo $id_personne; ?>"><?php echo $nom.' '.$prenom; ?></option>
                <?php	
					}
				?>
            </select>
           	<br><br>Rôle : 
            <select name="role">
            	<option value='0'>---</option>
            	<?php 
					$sql->select(" type_role_personne_structure","","","ORDER BY nom_type_role_structure ASC");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_role = $res['id_type_role_personne_structure'];
						$role = utf8_encode($res['nom_type_role_structure']);
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role; ?></option>
                <?php	
					}
				?>
            </select>
        </span>
        <footer><input type="submit" value="Ajouter"/></footer>
        </form>
   </article>
   
   
    
    <article>
    	<header>
        ALBUMS ASSOCIÉS
        </header>
        <span class="champs">
        <ul>
        <?php 
			$sql->select("album INNER JOIN structure_role_album ON album.id_album = structure_role_album.id_album INNER JOIN type_role_structure_album ON type_role_structure_album.id_type_role_structure_album=structure_role_album.id_type_role_structure_album","id_structure=".$id,"","ORDER BY titre");
			//echo $sql->getQuery();
			$sql->execute();
			while($res = $sql->result()){
				
				$id_album = $res['id_album'];
				
				$nom = utf8_encode($res['titre']);
				$nom_role = utf8_encode($res['nom_type_role_structure_album']);
				
				echo '<li><a href="structure-'.$id.'.php?arolestructure='.$res['id_structure_role_album'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_album.'.php">'.$nom.'</a></i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucune personne associé</i>";
			}
		?>
        </ul>
        
        </span>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
        <span class="champs">
        	Album : 
        	<select name="album">
            	<option value='0'>---</option>
            	<?php 
					$sql->select("album INNER JOIN artiste ON artiste.id_artiste=album.id_artiste","","*","ORDER BY nom_artiste, titre");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_album = $res['id_album'];
						$titre = stripslashes(utf8_encode($res['titre']));
						$nom_artiste = stripslashes(utf8_encode($res['nom_artiste']));
						
				?>
                <option value="<?php echo $id_album; ?>"><?php echo $titre.' - ('.$nom_artiste.')'; ?></option>
                <?php	
					}
				?>
            </select>
            <br><br>Rôle : 
            <select name="rolestructure">
            	<option value='0'>---</option>
            	<?php 
					$sql->select(" type_role_structure_album","","","ORDER BY nom_type_role_structure_album ASC");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_role = $res['id_type_role_structure_album'];
						$role = utf8_encode($res['nom_type_role_structure_album']);
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role; ?></option>
                <?php	
					}
				?>
            </select>
        </span>
        <footer><input type="submit" value="Ajouter"/></footer>
        </form>
   </article>
</div>