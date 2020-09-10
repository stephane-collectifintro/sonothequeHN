<!--<script>
$(function(){
	$.get('sidebar_playlist.php',function (data) {
		$('.col1').html(data);
	});
});
</script>-->
<?php require_once('header.php'); ?>




    <div id="center">
<php var_dump($_SESSION['id_utilisateur']); ?>
      <div class="description">
        <h3>mon compte</h3>
       </div><br/>
        <br/>
        <div class="formCompte">
        
          
          <?php
		  $sql = $pdo->query("SELECT * FROM utilisateur WHERE id_utilisateur='".$_SESSION['id_utilisateur']."'");
		  $res = $sql->fetch(PDO::FETCH_OBJ);
		  ?>
          <form action='' method='post' name='Form' id="modifForm">
          <?php
		  	if($res->type_utilisateur==2){
		  ?>
            <input type='text' name='structure' placeholder='Structure (Obligatoire)' rel="Structure" size='20' border='0' id="structure" value="<?php echo $res->structure_utilisateur; ?>" required><br>
          <?php } ?>
            <input type='text' name='nom' placeholder='Nom (Obligatoire)'  rel="Nom" size='20' border='0'  value="<?php echo $res->nom_utilisateur; ?>" required>
            <input type='text' name='prenom' placeholder='Prénom' size='20' border='0'  value="<?php echo $res->prenom_utilisateur; ?>">
            <input type='text' placeholder='Email (Obligatoire)'  rel="Email" name="mail"  value="<?php echo $res->mail_utilisateur; ?>" required>
            <input type='text' placeholder='Téléphone' name='tel'size='20' border='0' value="<?php echo $res->tel_utilisateur; ?>">
            <input type='text' placeholder='Adresse' name="adresse" size='20' border='0' value="<?php echo $res->adresse_utilisateur; ?>">
            <input type='text' placeholder='Code Postal' name="cp" size='20' border='0' value="<?php echo $res->cp_utilisateur; ?>">
            <input type='text' placeholder='Ville' name="ville"  size='20' border='0' value="<?php echo $res->ville_utilisateur; ?>"><br><br>
            <div id="submit" style="font-size:14px; line-height:30px; padding:0px 10px; background-color:#CCC; display:inline-block; float:right; color:#FFF;">Enregistrer</div><div class="clear"></div>
          </form>
          <br><br>
          <hr>
          <br><br>
         <form action='' method='post' name='Form' id="passwordform">
         		Modifier le mot de passe<br><br>
        	 <input type='password' placeholder='Mot de passe (6 caractères min)' name="mdp" rel="Mot de passe"  size='20' border='0'  value="" required>
            <input type='password' placeholder='Répétez mot de passe (Obligatoire)' name="repeatmdp" rel="Répétez Mot de passe"  size='20' border='0' value="" required><br><br>
           <div id="submit" style="font-size:14px; line-height:30px; padding:0px 10px; background-color:#CCC; display:inline-block; float:right; color:#FFF;">Modifier</div><div class="clear"></div>
         </form>
        </div>
    </div>
  
<?php require_once('footer.php'); ?>

<script>
		  function isValidEmailAddress(emailAddress) {
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
				return pattern.test(emailAddress);
			}
		  
		  
          $(document).ready(function() {
			 
			  //
			  $('#modifForm #submit').click(function(){
				  
				var error = "";	
				
				$('#modifForm').find('[required]:visible').each(function(){
					if($(this).val()==""){
						error += "- "+$(this).attr('rel')+"\n";
					}
				});
				
				if(error!=""){
					alert("Veuillez remplir les champs suivant : \n\n"+error);
					return false;	
				}
				
				if(!isValidEmailAddress($("input[name='mail']").val())) { alert("Adresse Email invalide");	return false; }
				
				$.ajax({ 
				   type: "POST", 
				   url: "modifcompte.php", 
				   data: $('#modifForm').serialize(), 
				   success: function(msg){ 
						
					  alert(msg);
					  
				   },
				   
				});
				return false; // ne change pas de page
				
			  });
			  
			  /////////-----------
			  
			  $('#passwordform #submit').click(function(){
				  
				var error = "";	
				
				$('#passwordform').find('[required]:visible').each(function(){
					if($(this).val()==""){
						error += "- "+$(this).attr('rel')+"\n";
					}
				});
				
				if(error!=""){
					alert("Veuillez remplir les champs suivant : \n\n"+error);
					return false;	
				}
				
				
				if($('input[name="mdp"]').val().length<6) { alert("Mot de passe trop court (6 caract\350res minimum)");	return false; }
				
				if($('input[name="mdp"]').val()!=$('input[name="repeatmdp"]').val()) { alert("Les mots de passe ne correspondent pas");	return false; }
				
				$.ajax({ 
				   type: "POST", 
				   url: "modifcompte.php", 
				   data: $('#passwordform').serialize(), 
				   success: function(msg){ 
						
					  alert(msg);
					  
				   },
				   
				});
				return false; // ne change pas de page
				
			  });
				  
			  
		  });		
          </script>