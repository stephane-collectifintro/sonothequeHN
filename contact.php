<?php require_once('header.php'); ?>

    <div id="center">
      <div class="description">
        <div class="form">
          <h1><span class="aniLight">Nous</span> contacter</h1>
          <form name='Form' id="formcontact">
            <input type='text' name='nom' rel="Nom" placeholder='Nom (obligatoire)' required  />
            <input type='text' name='prenom' placeholder='Prénom' />
            <input type='text' name="mail" rel="Email" placeholder='Email (obligatoire)' required />
            <input type='text' name='te' placeholder='Téléphone' />
            <input type='text'  name='objet' rel="Objet" placeholder='Objet  (obligatoire)' style='width:100%;' required />
            <textarea  name='commentaire' rel="Commentaire" placeholder="Commentaire  (obligatoire)" rows='6' cols='40' style='width:100%;' required></textarea>
            <button type="button" name='submit' id="submit" class="btn btn-primary pull-right" style="margin:15px 0 0 0">Envoyer</button>
            <div class="clearfix"></div>
          </form>
        </div>
        <iframe style="margin-bottom:20px;" width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=126,+route+de+Mirville++76210+BOLBEC+&amp;aq=&amp;sll=49.580931,0.465842&amp;sspn=0.064332,0.072441&amp;g=126,+route+de+Mirville&amp;ie=UTF8&amp;hq=&amp;hnear=126+Route+de+Mirville,+76210+Bolbec,+Seine-Maritime,+Haute-Normandie&amp;t=m&amp;ll=49.58167,0.464859&amp;spn=0.02226,0.068836&amp;z=13&amp;output=embed"></iframe>
        <div cl class="adresse"> <b>La Fabrik à Sons</b> <br/>
          126, route de Mirville <br/>
          76210 BOLBEC <br/>
          Tél : 02 35 31 55 78<br/>
          <br/>
          Mail : <a href="mailto:contact@sonotheque-hn.com" target="_blank">contact@sonotheque-normandie.com</a></div>
      </div>
    </div>
    
    <script>
	function isValidEmailAddress(emailAddress) {
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
				return pattern.test(emailAddress);
			}
			
    $(document).ready(function() {
			 
			 
			  $('#formcontact #submit').click(function(){
				  
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
				
				alert($('#formcontact').serialize());
				$.ajax({ 
				   type: "POST", 
				   url: "envoimail.php", 
				   data: $('#formcontact').serialize(), 
				   success: function(msg){ 
						
					  alert(msg);
					  load_content('contact','contact.php');
					  
				   },
				   
				});
				return false; // ne change pas de page
				
			  });
				  
			  
		  });
    
    </script>
    
  
<?php require_once('footer.php'); ?>