<?php

$sql = new sql();

//- - - - - - - - - - -  //
//- - - - actu - - - -  //
//- - - - - - - - - - -  //

$sql->select("utilisateur",'id_utilisateur='.$id);
$sql->execute();
$res = $sql->result();
//
$structure = utf8_encode($res['structure_utilisateur']);
$nom = utf8_encode($res['nom_utilisateur']);
$prenom = utf8_encode($res['prenom_utilisateur']);
$mail = $res['mail_utilisateur'];
$tel = utf8_encode($res['tel_utilisateur']);
$adresse = utf8_encode($res['adresse_utilisateur']);
$cp = utf8_encode($res['cp_utilisateur']);
$ville = utf8_encode($res['ville_utilisateur']);
//
?>

<div id="content">
<div class="titre">Utilisateur</div>	
	<?php 
	
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           
        </header>
        
        <?php if($structure!=""){ ?>
        <span class='champs'><strong>Structure :</strong><?php echo stripslashes($structure); ?></span>
        <?php } ?>
        
        <span class='champs'><strong>Nom : </strong><?php echo stripslashes($nom); ?></span>
        
        <span class='champs'><strong>Prénom : </strong><?php echo stripslashes($prenom); ?></span>
        
        <span class='champs'><strong>email : </strong><?php echo stripslashes($mail); ?></span>
        
        <span class='champs'><strong>Tél. : </strong><?php echo stripslashes($tel); ?></span>
        
        <span class='champs'><strong>Adresse : </strong><?php echo stripslashes($adresse); ?></span>
        
        <span class='champs'><strong>CP : </strong><?php echo stripslashes($cp); ?></span>
        
        <span class='champs'><strong>Ville : </strong><?php echo stripslashes($ville); ?></span>
        
        <footer><a href="liste_utilisateur.php"><input type="button" value="Retour"/></a></footer>
        
    </article>
    </form>
    
    
    
    
       
    
  
</div>





