$(document).ready(function(){
	
	$('#chargement').hide();
	
	$(document).on('click','a:not([target="_blank"]):not([type="fancybox"])', function() {
			//On met l'élément courant dans une variable, pour améliorer les performances
			var $t = $(this);
			//On appelle la fonction qui fera la requete en ajax, et gérera la pile de l'historique
			load_content($t.attr('title'),$t.attr('href'));
			//On ne suit pas le lien
			return false;
	});
	
	
});


function load_content(title,url,skipHistory) {
	
	$('#content #col2').animate({opacity:0},100,function(){
		$('#chargement').fadeIn(100);
		$.get(url,function (data) {
			
			//On met à jour le itre de la page
			document.title = title;
			//On défini l'objet d'état
			var stateObj = {
					title: title,
					url: url
			};
			
			//Si la variable skipHistory est à false, on lance la méthode pushstate
			if (!skipHistory) {
					//On vérifie que la fonction pushState est bien définie
					if (typeof window.history.pushState == 'function') {
							window.history.pushState(stateObj,title,url);
					}
			}
			
			//On charge le contenu
			$('#content #col2').html(data).promise().done(init_items);
				
			$.get('sidebar_left.php', function(data) {
			  	$('#content #col1').html(data);
				$('#content #col1').html(data);
				$('#content #col1 a').not('a[target="_blank"]').click(function() {
					//On met l'élément courant dans une variable, pour améliorer les performances
					var $t = $(this);
					//On appelle la fonction qui fera la requete en ajax, et gérera la pile de l'historique
					load_content($t.attr('title'),$t.attr('href'));
					//On ne suit pas le lien
					return false;
				});
			});  
				
			$('#content #col2 a').not('a[target="_blank"]').click(function() {
				//On met l'élément courant dans une variable, pour améliorer les performances
				var $t = $(this);
				//On appelle la fonction qui fera la requete en ajax, et gérera la pile de l'historique
				load_content($t.attr('title'),$t.attr('href'));
				//On ne suit pas le lien
				return false;
			});
			$('#chargement').fadeOut(100);
			$('#content #col2').animate({opacity:1},100);
			
		});
    });  
}
//On détecte les événement sur la pile de l'historique
window.onpopstate = function(event) {
        //Si event.state est définie (c'est à dire que la page précédente fait partie de l'historique courant), on charge le contenu
        //load_content(event.state.title, window.location.pathname, true);
		if (event.state) {
                load_content(event.state.title, window.location.pathname, true);
        } else {
                //Si event.state n'est pas définie, on créer un nouvel objet d'état
                var stateObj = {
                        title: document.title,
                        url: window.location.pathname 
                };
                //On modifie l'entrée actuelle
                window.history.replaceState(stateObj,document.title,window.location.pathname);
        }
}