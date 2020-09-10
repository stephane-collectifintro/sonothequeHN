<?php require_once('header.php'); ?>

    <div id="center">
      <div class="description">
        <h3>Créer un compte</h3>
        <b>c'est disposer d'une identité car toutes les modifications sont rattachées à ce compte.</b><br/>
        <br/>
        Il est simple de créer un compte:<br/><br>
        1 - Remplir la fiche du profil<br/>
        2 - Créer un nom d'utilisateur<br/>
        3 - Créer un mot de passe<br/>
        4 - Cliquer sur « Créer un compte »<br/><br>
        Et voilà, vous avez maintenant votre page perso et pouvez contribuer / améliorer le contenu de la sonothèque.</div><br/>
        <br/>
        <div class="formCompte">
        
          <script>
		  function isValidEmailAddress(emailAddress) {
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
				return pattern.test(emailAddress);
			}
		  
		  
          $(document).ready(function() {
			  
			  
			  $('#submit').click(function(){
				  
				var error = "";	
				
				$('form').find('[required]:visible').each(function(){
					if($(this).val()==""){
						error += "- "+$(this).attr('rel')+"\n";
					}
				});
				
				if(error!=""){
					alert("Veuillez remplir les champs suivant : \n\n"+error);
					return false;	
				}
				
				if(!isValidEmailAddress($("input[name='mail']").val())) { alert("Adresse Email invalide");	return false; }
				
				if($('input[name="mdp"]').val().length<6) { alert("Mot de passe trop court (6 caract\350res minimum)");	return false; }
				
				if($('input[name="mdp"]').val()!=$('input[name="repeatmdp"]').val()) { alert("Les mots de passe ne correspondent pas");	return false; }
				
				$.ajax({ 
				   type: "POST", 
				   url: "inscription.php", 
				   data: $('#inscriptionForm').serialize(), 
				   success: function(msg){ 
						
					  alert(msg);
					  
				   },
				   
				});
				return false; // ne change pas de page
				
			  });
				  
			  
		  });		
          </script>
          <form action='' method='post' name='Form' id="inscriptionForm">
          	
            <input type='text' name='nom' placeholder='Nom (Obligatoire)'  rel="Nom" size='20' border='0' required>
            <input type='text' name='prenom' placeholder='Prénom' size='20' border='0'>
            <input type='text' placeholder='Email (Obligatoire)'  rel="Email" name="mail" required>
            <input type='text' placeholder='Téléphone' name='tel'size='20' border='0'>
            <input type='text' placeholder='Adresse' name="adresse" size='20' border='0'>
            <input type='text' placeholder='Code Postal' name="cp" size='20' border='0'>
            <input type='text' placeholder='Ville' name="ville"  size='20' border='0'><br><br>
            <input type='password' placeholder='Mot de passe (Obligatoire)(6 caractères min)' name="mdp" rel="Mot de passe"  size='20' border='0' required>
            <input type='password' placeholder='Répétez mot de passe (Obligatoire)' name="repeatmdp" rel="Répétez Mot de passe"  size='20' border='0' required><br><br>
            <input type='button' name='submit' value='Créer un compte' border='0' id="submit">
          
          </form>
        </div>
    </div>
  
<?php require_once('footer.php'); ?>