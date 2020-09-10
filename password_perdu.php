<?php require_once('header.php'); ?>

    <div id="center">
      <div class="description">
        <h3>Mot de passe perdu ?</h3>
        Pour récupérer un mot de passe, saisissez l'adresse email associé à votre compte, puis validez. Un nouveau mot de passe vous seras envoyé par email à l'adresse indiquée.</div><br/>
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
				
				$.ajax({ 
				   type: "POST", 
				   url: "reinit_password.php", 
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
          	<input type='text' placeholder='Votre Adresse Email' name="mail" rel="Votre adresse Email" border='0' required style="display:block; margin:0 auto; width:530px; text-align:center;"><br><br>
            <input type='button' name='submit' value='Réinitialiser le mot de passe' border='0' id="submit">
          </form>
        </div>
    </div>
  
<?php require_once('footer.php'); ?>