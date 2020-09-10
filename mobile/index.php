<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=9"/> -->
    <title>La Sonotheque Normandie - Mobile</title>
    <meta name="apple-itunes-app" content="app-id=703327274r" />

    <meta name="description" content="Sonotheque Normandie - La musique normande gratuite">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Content-Language" content="fr">
		<meta name="Description" content="La Sonothèque Normandie est une plateforme de streaming gratuite pour écouter la musique et les groupes de Normandie.">
		<meta name="Keywords" content="artiste normandie,sonotèque, normandie, musique normandie, streaming normandie, plateforme streaming, gratuite, musiques actuelles normandie, musique normande, artiste normand">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style>
body{
	background-color:#2B2828;
}
#logo{
	width: 249px;
}
p{
	color:#fff;
	margin-top:180px;
}
#bouton{
	background-color:#FF445D;
	width:250px;
	color:#fff;
	font-size:20px;
	text-align:center;
	margin-top:20px;
	padding: 10px 5px;
	border-raduis:10px;
}
.logo{
	width: 240px;
    height: auto;
    display: block;
    position: absolute;
    top: -12px;
}
</style>
</head>
<body>
	<div class="container">
		<div class="center-block" id="logo">
			<div class="logo">
       	    		<img class="center-block" src="../img/logo.svg" width="209" height="144">
         	</div>
		</div>
		<div class="container"><p>La Sonothèque Normandie est un site d’écoute en ligne dédié aux artistes normands.<br/> Afin de rendre l’expérience plus agréable sur mobile nous vous invitons à télécharger gratuitement l’application.</p></div>


<script>
        $(document).ready(function (){

		$(function(){
    			$('#bouton').click(function() {
        			  if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
             			window.location.href = 'https://play.google.com/store/apps/details?id=com.collectifintro.sono';
         		  }if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
            				 window.location.href = 'https://itunes.apple.com/fr/app/sonotheque/id703327274?mt=8';
         		  }
    			});
		});

       
        });
</script>
		<div class="center-block" id="bouton">Télécharger l'application</div>
    	
</body>
</html>