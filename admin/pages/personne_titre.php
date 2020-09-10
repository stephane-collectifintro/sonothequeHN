<?php

$sql = new sql();
//
//============== SUPPR TRACK =================//
//
if(isset($_GET['idpersonnetitre']) && $_GET['idpersonnetitre']!=""){
	
	$sql->delete('role_personne_titre','id_role_personne_titre='.$_GET['idpersonnetitre']);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne_titre-".$id.".php';</script>";	
	}
			
}
//
//============== PERSONNE =================//
//
if((isset($_POST['role']) && $_POST['role']!==0) && (isset($_POST['nom']) && $_POST['nom']!=="")){
	//
	$nom = utf8_encode(addslashes($_POST['nom']));
	$role = utf8_encode($_POST['role']);
	$idtitre = $_POST['idtitre'];
	//update type_album			
	$champs = array('nom_personne','id_pj','id_type_role_personne_titre');
	$values = array($nom,$idtitre,$role);
	$sql->insert('role_personne_titre',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='personne_titre-".$id.".php';</script>";	
	}			
}




?>

<div id="content">
<div class="titre">PERSONNE/TITRE</div>	
	
        <?php
		$sql->select('chanson INNER JOIN portfolio_sonotheque ON chanson.id_morceau = portfolio_sonotheque.id_pj','id_album='.$id,"","ORDER BY piste ASC");
		//echo $sql->getQuery();
		$sql->execute();
		while($res = $sql->result()){
			
			$piste_chanson = $res['piste'];
			$duree_chanson = $res['duree'];
			$nom_chanson = utf8_encode($res['nom']);
			$id_pj = $res['id_pj'];
			$path = $res['url_pj'];
			$nom_fichier = $res['nom_pj'];
						
		?>
        <article>
    	<header>
        <?php echo $piste_chanson.' - '.$nom_chanson; ?>
        </header>
        
        <span class="champs">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
        	<select name="role">
            	<option value='0'>---Rôle---</option>
            	<?php 
					$sql2 = new sql();
					$sql2->select("type_role_personne_titre","","","ORDER BY nom_type_role_personne_titre ASC");
					$sql2->execute();
					while($res2 = $sql2->result()){
						
						$id_role = $res2['id_type_role_personne_titre'];
						$role = utf8_encode($res2['nom_type_role_personne_titre']);
						
				?>
                <option value="<?php echo $id_role; ?>"><?php echo $role; ?></option>
                <?php	
					}
				?>
            </select>
        	<!--<select name="personne">
            	<option value='0'>---</option>
            	<?php 
					$sql2 = new sql();
					$sql2->select("personne","","","ORDER BY nom_personne, prenom_personne");
					$sql2->execute();
					while($res2 = $sql2->result()){
						
						$id_personne = $res2['id_personne'];
						$prenom = utf8_encode($res2['prenom_personne']);
						$nom = utf8_encode($res2['nom_personne']);
				?>
                <option value="<?php echo $id_personne; ?>"><?php echo $nom.' '.$prenom; ?></option>
                <?php	
					}
				?>
            </select>-->
            <input type="hidden" name="idtitre" value="<?php echo $id_pj; ?>" >
            <input type="text" placeholder="Nom" name="nom"><br><br>            
           	<input type="submit" value="ajouter">
        </form>   
        </span>
        <span class="champs">
        <ul>
        <?php 
			$sql2->select("role_personne_titre INNER JOIN type_role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre=role_personne_titre.id_type_role_personne_titre","role_personne_titre.id_pj=".$id_pj,"","ORDER BY type_role_personne_titre.nom_type_role_personne_titre, role_personne_titre.nom_personne");
			
			$sql2->execute();
			while($res2 = $sql2->result()){
				
				$idpersonnetitre = $res2['id_role_personne_titre'];
				$nom = utf8_encode($res2['nom_personne']);
				$nom_role = utf8_encode($res2['nom_type_role_personne_titre']);
				//
				echo '<li><a href="personne_titre-'.$id.'.php?idpersonnetitre='.$idpersonnetitre.'"><img src="images/close_link.png" height="16" style="vertical-align:bottom" /></a> <strong>'.$nom_role.'</strong> :  <i>'.$nom.'</i></li>';
			
			}
			if($sql->getNumRows()===0){
				echo "<i style='color:#D4D4D4;'>Aucune personne associée</i>";
			}
		?>
        </ul>
        </span>
        <div class="clear"></div>
        
   		</article>
        
        <?php } ?>

       
        
    
    
</div>





