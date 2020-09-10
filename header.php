		<?php
	require_once('init.php');
	require_once('cn.php');
	require_once('class/texte.class.php');
	require_once('fonctions/fonctions.php');
?>
<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest") {
	//Si on est en Ajax

}else{
	//Si on n'est pas en ajax, on appelle la structure de page
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>

    <!-- META -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=9"/> -->
    <title>La Sonotheque Normandie - Site d'&eacute;coute gratuite d'artistes de Normandie</title>
    <meta name="apple-itunes-app" content="app-id=703327274r" />
    <?php require_once("ogmeta.php"); ?>

    <meta name="description" content="Sonotheque Normandie - La musique normande gratuite">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Content-Language" content="fr">
		<meta name="Description" content="La Sonothèque Normandie est une plateforme de streaming gratuite pour écouter la musique et les groupes de Normandie.">
		<meta name="Keywords" content="artiste normandie,sonotèque, normandie, musique normandie, streaming normandie, plateforme streaming, gratuite, musiques actuelles normandie, musique normande, artiste normand">



    <!-- CSS -->

  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  	<link rel="stylesheet" href="css2/normalize.css">
    <link rel="stylesheet" href="css2/main.css">
    <link rel="stylesheet" href="css2/fonts.css">
    <link rel="stylesheet" href="css2/styles.css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.4/jquery.fancybox.css" type="text/css" media="screen" />


    <!-- JAVASCRIPT
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="js/history.js"></script>
		<script src="js/audio.js"></script>
		<script src="js/player.js"></script>
    <script src="js/login.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.4/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="https://malsup.github.io/jquery.cycle.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

  </head>
  <body onselectstart="return false" oncontextmenu="return false" ondragstart="return false">
  <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> or <a href="https://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
<!-- Header -->
<!-- <div id="fbconnect">fb</div> -->
	<?php require_once('menu_top.php'); ?>
  <?php require_once('recherche_basic.php'); ?>


       <section id="content" >
        <div class="content-center" style="position:relative;">

        <div id="chargement" style="margin:0 auto; width:100px; text-align:center; position:absolute; left:50%; right: 50%; top:100px;"><img src="img/loading.gif" width="20"  /><br>Chargement</div>
          <div class="column col1" id="col1">
            <?php require_once('sidebar_left.php'); ?>
          </div>
          <div class="column col2" id="col2">
<?php } ?>
