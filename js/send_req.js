$(document).ready(function() {

$('.connexion').click(function() {

   
        $.ajax({ 
           type: "POST", 
           url: "connect.php", 
           data: "login="+$("#log").val()+"&mdp="+$("#mdp").val(), 
           success: function(msg){ 
                       if(msg==1) 
                        {		
								load_content('profil','profil.php');
                        }
                        else // Erreur appel login.php
                        {		
								load_content('home','home.php');
                        }
           }
        });
        return false; // ne change pas de page

    
});

});