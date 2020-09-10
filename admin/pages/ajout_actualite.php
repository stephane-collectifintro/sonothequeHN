<?php

$sql = new sql();


//============== INFOS =================//
//
if((isset($_POST['titre']) && $_POST['titre']!="")){
	//
	$titre = addslashes(utf8_decode($_POST['titre']));
	$date = $_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
	$texte = addslashes(utf8_decode($_POST['texte']));
	//		
	$champs = array('titre_actualite','texte_actualite','date_actualite');
	$values = array($titre,$texte,$date);
	$sql->insert('actualite',$champs,$values);
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='actualite-".$sql->insertID().".php';</script>";	
	}
				
}







?>

<div id="content">
<div class="titre">ajouter actualité</div>	
	<?php 
	$jour = date('d');
	$mois = date('m');
	$annee = date('Y');
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
           <select name="jour" >
                  <?php
                        for($i=1;$i<=31;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$jour){ echo "selected"; }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$jour){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="mois" >
                  <?php
                        for($i=1;$i<=12;$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                            if($i==$mois){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$mois){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select>
                <select name="annee">
                  <?php
                        
                        for($i=date('Y')-1;$i<=date('Y');$i++){
                            if($i<10){
                                $zero = "0";
                            }else{
                                $zero = "";	
                            }
                    ?>
                  <option value="<?php echo $zero.$i; ?>" <?php if($i==$annee){ echo "selected"; } ?> ><?php echo $zero.$i; ?></option>
                  <?php		
                        }
                    ?>
                </select> 
        </header>
        
        <span class='champs'><strong>Titre :</strong><br /><input type="text" name="titre"/></span>
        
        <span class='champs'><strong>Texte :</strong><br />
        	<textarea name="texte" class="tinymce"></textarea>
        </span>
        
        <footer><input type="submit" value="ajouter"/></footer>
        
    </article>
    </form>
  
</div>





