$(document).ready(function() {
	
	$('#connect a').not('a[target="_blank"]').click(function() {
			//On met l'élément courant dans une variable, pour améliorer les performances
			var $t = $(this);
			//On appelle la fonction qui fera la requete en ajax, et gérera la pile de l'historique
			load_content($t.attr('title'),$t.attr('href'));
			//On ne suit pas le lien
			return false;
	});


	function connexion(){

		$.ajax({ 
			type: "POST", 
			url: "connect.php", 
			data : { login: $("#log").val(), mdp: $("#mdp").val() },
			success: function(msg){ 
				
			  $('.connect').html(msg);
			  /*var current_href = $(location).attr('href');
				var current_title = $(document).attr('title');
				load_content(current_title,current_href);*/
				location.reload();
			  
		    },
		    error: function(msg){ 
				
		    }
		   
		});
		return false; // ne change pas de page

	}


	function facebook_connexion(){

		window.location.href = "fblogin/?origin="+window.location.href;

	}


	function deconnexion(){

		$.ajax({ 
		   type: "POST", 
		   url: "deconnexion.php", 
		   data: "logoff=true", 
		   success: function(msgoff){ 
		   
			  	$('.connect').html(msgoff);
			  	$('header#profile').remove();
			  
			  	var current_href = $(location).attr('href');
				var current_title = $(document).attr('title');
			  	load_content(current_title,current_href);

		   }
		});
		return false; // ne change pas de page
	}

	function login_enter(e) {
	    if(e.which == 13) {
	        connexion();
	    }
	}


	$(document).on("click",".connexion",connexion);

	$(document).on("click","#fbconnect",facebook_connexion);
		
	$(document).on("submit","#connection",connexion);

	$(document).on("keypress","#connection",login_enter);
	
	$(document).on("click","#deconnexion",deconnexion);

});