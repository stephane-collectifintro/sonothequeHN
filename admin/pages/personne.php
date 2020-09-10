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
	$sql->update('personne',$champs,$values,"id_personne='".$id."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_personne.php';</script>";	
	}
				
}
//
//============== ALBUM =================//
//
if((isset($_POST['album']) && $_POST['album']!==0) && (isset($_POST['role']) && $_POST['role']!==0)){
	//
	$album = utf8_encode($_POST['album']);
	$role = utf8_encode($_POST['role']);
	//update type_album			
	$champs = array('id_personne','id_album','id_type_role');
	$values = array($id,$album,$role);
	$sql->insert('a_un_role',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne-".$id.".php';</script>";	
	}			
}

//
//============== SUPPR ALBUM =================//
//
if(isset($_GET['arole']) && $_GET['arole']!=''){
	//
	$sql->delete('a_un_role',"id_a_un_role=".$_GET['arole']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne-".$id.".php';</script>";	
	}				
}

//
//============== STRUCTURE =================//
//
if((isset($_POST['structure']) && $_POST['structure']!==0) && (isset($_POST['rolestructure']) && $_POST['rolestructure']!==0)){
	//
	$structure = utf8_encode($_POST['structure']);
	$rolestructure = utf8_encode($_POST['rolestructure']);
	//		
	$champs = array('id_personne','id_structure','id_type_role_struct');
	$values = array($id,$structure,$rolestructure);
	$sql->insert('a_un_role_structure',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne-".$id.".php';</script>";	
	}
				
}
//
//============== SUPPR STRUCTURE =================//
//
if(isset($_GET['arolestructure']) && $_GET['arolestructure']!=''){
	//
	$sql->delete('a_un_role_structure',"id_a_un_role_structure=".$_GET['arolestructure']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne-".$id.".php';</script>";	
	}
				
}

?>
<div id="content">
<div class="titre">MODIFIER personne</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('personne',"id_personne='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$nom = utf8_encode($res['nom_personne']);
	$prenom = utf8_encode($res['prenom_personne']);
	$adresse = utf8_encode($res['adresse_personne']);
	$cp = utf8_encode($res['cp_personne']);
	$ville = utf8_encode($res['ville_personne']);
	$tel = utf8_encode($res['tel_personne']);
	$mail = utf8_encode($res['courriel_personne']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
               
        </header>
        
        <span class='champs'><strong>Nom :</strong><br /><input type="text" name="nom" value="<?php echo $nom;  ?>" /></span>
        
        <span class='champs'><strong>Prenom :</strong><br /><input type="text" name="prenom" value="<?php echo $prenom;  ?>" /></span>
        
        <span class='champs'><strong>Adresse :</strong><br /><input type="text" name="adresse" value="<?php echo $adresse;  ?>" /></span>
        
        <span class='champs'><strong>Code Postal :</strong><br /><input type="text" name="cp" value="<?php echo $cp;  ?>" /></span>
        
        <span class='champs'><strong>Ville :</strong><br /><input type="text" name="ville" value="<?php echo $ville;  ?>" /></span>
        
        <span class='champs'><strong>Téléphone :</strong><br /><input type="text" name="tel" value="<?php echo $tel;  ?>" /></span>
        
        <span class='champs'><strong>Mail :</strong><br /><input type="text" name="mail" value="<?php echo $mail;  ?>" /></span>
       
        <footer><input type="submit" value="Modifier"/></footer>
        
    </article>
    </form>
    
    
    
    
    <article>
    	<header>
        ALBUMS ASSOCIÉS
        </header>
        <span class="champs">
        <u><strong>MUSICIEN</strong></u>
        <br><br>
        <ul>
        <?php 
			$sql->select("album INNER JOIN a_un_role ON album.id_album = a_un_role.id_album INNER JOIN type_role ON type_role.id_type_role=a_un_role.id_type_role","type_type_role='musicien' AND id_personne=".$id,"","ORDER BY titre");
			
			$sql->execute();
			while($res = $sql->result()){
				
				$id_album = $res['id_album'];
				
				$album = utf8_encode($res['titre']);
				$nom_role = utf8_encode($res['nom_type_role']);
				
				echo '<li><a href="personne-'.$id.'.php?arole='.$res['id_a_un_role'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="album-'.$id_album.'.php">'.$album.'</a></i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucun album associé en tant que musicien</i>";
			}
		?>
        </ul>
        <br><br>
        <u><strong>TECHNICIEN</strong></u>
        <br><br>
        <ul>
        <?php 
			$sql->select("album INNER JOIN a_un_role ON album.id_album = a_un_role.id_album INNER JOIN type_role ON type_role.id_type_role=a_un_role.id_type_role","type_type_role='technicien' AND id_personne=".$id,"","ORDER BY titre");
			
			$sql->execute();
			while($res = $sql->result()){
				
				$id_album = $res['id_album'];
				
				$album = utf8_encode($res['titre']);
				$nom_role = utf8_encode($res['nom_type_role']);
				
				echo '<li><a href="personne-'.$id.'.php?arole='.$res['id_a_un_role'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="album-'.$id_album.'.php">'.$album.'</a></i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucun album associé en tant que technicien</i>";
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
            <select name="role">
            	<option value='0'>---</option>
            	<?php 
					$sql->select("type_role","","","ORDER BY type_type_role ASC, nom_type_role ASC");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_role = $res['id_type_role'];
						$role = utf8_encode($res['nom_type_role']);
						$typerole = utf8_encode($res['type_type_role']);
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role.' ('.$typerole.')'; ?></option>
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
        STRUCTURES ASSOCIÉS
        </header>
        <span class="champs">
        <ul>
        <?php 
			$sql->select("structure_sonotk INNER JOIN a_un_role_structure ON structure_sonotk.id_structure = a_un_role_structure.id_structure INNER JOIN type_role_personne_structure ON type_role_personne_structure.id_type_role_personne_structure=a_un_role_structure.id_type_role_struct","a_un_role_structure.id_personne=".$id,"","ORDER BY nom_structure");
			//echo $sql->getQuery();
			$sql->execute();
			while($res = $sql->result()){
				
				$id_structure = $res['id_structure'];
				$nom = utf8_encode($res['nom_structure']);
				$nom_role = utf8_encode($res['nom_type_role_structure']);
				
				echo '<li><a href="personne-'.$id.'.php?arolestructure='.$res['id_a_un_role_structure'].'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i><a href="personne-'.$id_structure.'.php">'.$nom.'</a></i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucune personne associé</i>";
			}
		?>
        </ul>
        
        </span>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
        <span class="champs">
        	Structure : 
        	<select name="structure">
            	<option value='0'>---</option>
            	<?php 
					$sql->select("structure_sonotk","","","ORDER BY nom_structure");
					$sql->execute();
					while($res = $sql->result()){
						
						$id_structure = $res['id_structure'];
						$nom = utf8_encode($res['nom_structure']);
						
				?>
                <option value="<?php echo $id_structure; ?>"><?php echo $nom; ?></option>
                <?php	
					}
				?>
            </select>
           	<br><br>Rôle :
            <select name="rolestructure">
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
</div>