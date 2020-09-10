<?php 
require('cn.php');
require_once('class/getid3/getid3.php'); 

$id=$_GET['id'];
 $s0 = $pdo->query("SELECT * FROM album INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=album.id_jaquette WHERE album.id_album=".$id." ORDER BY annee_sortie DESC"); 
try {
	 $s0 = $pdo->prepare('SELECT *
	FROM album
	INNER JOIN portfolio_sonotheque
	   ON portfolio_sonotheque.id_pj = album.id_jaquette
	WHERE album.id_album = :id
	ORDER BY annee_sortie DESC;'); // oui, les requêtes aussi se terminent par ;
	$s0->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	$s0->execute();
	 
	
	
	$res0 = $s0->fetch(PDO::FETCH_OBJ);
	$id_album = $res0->id_album;
    $nom_album = stripslashes(utf8_encode($res0->titre));
    $annee = $res0->annee_sortie;
    $jaquette = $_MUSIC_ROOT.$res0->url_pj;
	$id_artiste = $res0->id_artiste;
    if($annee==0) $annee="";
	
	$s2 = $pdo->query("SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo WHERE artiste.id_artiste=".$id_artiste);
		$res2 = $s2->fetch(PDO::FETCH_OBJ);
		//
		$nom_artiste = stripslashes(utf8_encode($res2->nom_artiste));
		$bio_artiste = stripslashes(utf8_encode($res2->bio_artiste));
		$url_site = stripslashes(utf8_encode($res2->url_site_web));
		$url_site_2 = stripslashes(utf8_encode($res2->url_site_web_2));

		$s1 = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$id_album." ORDER BY piste ASC");
		while($res1 = $s1->fetch(PDO::FETCH_OBJ)){
			
			$id_titre = $res1->id_pj;
			$titre = utf8_encode($res1->nom);
			$url=$_MUSIC_ROOT.$res1->url_pj;
			$id_chanson = $res1->id_chanson;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res1->piste;
			//$token = uniqid('azertyuiop',false);
			$token = $url;									
			
					
			}
			
	
 }
 
catch (PDOException $e) {
  	echo "DataBase Error: ".$e->getMessage();
} catch (Exception $e) {
 	echo "General Error: ".$e->getMessage();
}
//var_dump($res0);
	   
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml"> 

<!-- Facebook Open Graph Meta Tags -->
<meta property="og:title" content="La Sonotheque-hn vous présente sa playlist" />
<meta property="og:type" content="album" />
<meta property="og:url" content="http://sonotheque-hn.com/" />
<meta property="og:image" content="http://sonotheque-hn.com/<?php echo $jaquette; ?>" />
<meta property="og:site_name" content="La Sonotheque-hn" />
<meta property="og:description" content="Albulm proposé par la Sonotheque-hn" />
<meta property="og:audio" content="http://sonotheque-hn.com/<?php echo $url; ?>" />
<meta property="og:audio:title" content="<?php echo $titre;?>" />
<meta property="og:audio:artist" content="<?php echo $nom_artiste; ?>" />
<meta property="og:audio:album" content="<?php echo $nom_album; ?>" />
<meta property="og:audio:type" content="application/mp3" />

<fb:like href="http://developers.facebook.com/" width="450" height="80" />


<!-- Open Graph Meta Tags by: www.MetaTagGenerator.org -->


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $nom_artiste; ?></title>

<style>
body, HTML{
	margin:0;
	padding:0;
}
@font-face {
    font-family: 'BrandonBold';
    src: url('font/Brandonbld.eot');
    src: url('font/Brandonbld.woff') format('woff'),
    url('../font/Brandonbld.svg#BrandonGrotesque-Bold') format('svg');
	font-weight: normal;
	font-style: normal;
       }

 @font-face {
    font-family: 'Brandonlight';
    src: url('font/Brandonlight.eot');
    src: url('font/Brandonlight.woff') format('woff'),
    url('Brandonlight.svg#BrandonGrotesque-Light') format('svg');
	font-weight: normal;
	font-style: normal;
       }
	   
div.music_album{
	height:220px;
	background-color:#E6E6E6;
	
}

div.infos_album{
	width:123px;
	height:95px;
	font-size:14px;
	color:#808080;
	float:left;
	padding:5px;
}

div.infos_album div.img_album{
	width:122px;
	height:125px;
	font-size:12px;

}
div.img_album img.play_jaquette {
	position: absolute;
	left: 37px;
	top: 69px;
	z-index: 1;
	opacity: 0;
	-webkit-transition: opacity 0.2s ease-out;
	-moz-transition: opacity 0.2s ease-out;
	-ms-transition: opacity 0.2s ease-out;
	-o-transition: opacity 0.2s ease-out;
	transition: opacity 0.2s ease-out;
}
div.img_album:hover img.play_jaquette {
	opacity:1;
	-webkit-transition: opacity 0.2s ease-out;
	-moz-transition: opacity 0.2s ease-out;
	-ms-transition: opacity 0.2s ease-out;
	-o-transition: opacity 0.2s ease-out;
	transition: opacity 0.2s ease-out;
}
div.infos_album{
	width:20%;	
}
div.infos_album header{
	color:#333333;
	font-family:'Verdana';
	
}

div.list_album{
	width:75%;
	height:220px;
	float:left;
	overflow:auto;
	border-left:1px solid #CCCCCC;
}

div.list_album ul{
	margin:0;
	padding:0;
	
}

div.list_album ul li{
	list-style-type:none;
	font-family:'BrandonBold';
	font-size:14px;
	color:#000;
	text-indent:5px;
	line-height:25px;
	border-bottom-color:#CCCCCC;
	border-bottom-style:solid;
	border-bottom-width:1px;	
}
div.list_album ul li.select_music{
	color:#FF445D;
}

div.list_album ul li.select_music:last-child{
	color:#FF445D;
}

div.list_album ul li.selected_music {
	color: #FF445D;
}
div.list_album ul li.selected_music:last-child {
	color: #FF445D;
}

div.list_album ul li:last-child{
	list-style-type:none;
	font-family:'BrandonBold';
	font-size:14px;
	color:#000;
	text-indent:5px;
	line-height:20px;
	border-left-style:none;
	border-bottom-style:none;
	
}

div.list_album ul li .time{
	font-family:'Brandonlight';
	font-size:14px;
	color:#000; 	
}

div.player {
	position: relative;
	
	height: 50px;
	background-color: #202322;
	background-image: url(../img/bg-footer.png);
	background-position: top left;
	background-repeat: repeat-x;
}

div.player div.actions {
	float: left;
	width: 120px;
	height: 50px;
	position: relative;
	padding-top: 22px;
	padding-left:15px;
	
}
div.player div.before {
	float: left;
	width: 15px;
	height: 9px;
	background: url(img/before.jpg) center center no-repeat;
}
div.player div.play {
	float: left;
	width: 17px;
	height: 18px;
	background: url(img/play.jpg) center center no-repeat;
	margin: -5px 30px 0 30px;
}
div.player div.pause {
	float: left;
	width: 17px;
	height: 18px;
	background: url(img/pause.png) center center no-repeat;
	margin: -5px 30px 0 30px;
}
div.player div.next {
	float: left;
	width: 15px;
	height: 9px;
	background: url(img/next.jpg) center center no-repeat;
}

div.player div.progress {
	float: left;
	width: 255px;
	height: 50px;
	padding-top: 19px;
	text-align:right;
	
}
.sono {
	width: 100%;
	height: 33px;
	padding: 1px 1px;
	background-color:#ff445d;
}
div.player div.pres {
	float: left;
	width: 240px;
	height: 50px;
	font-size:12px;
	text-align:right;
	padding-right:8px;
}

div.player div.pres a{
	color:#666;
	font-family:Arial, Helvetica, sans-serif;
	line-height:75px;
	text-decoration:none;
}
div.player div.pres a:hover{
	text-decoration:underline;
	
}

div.progress div.current_time,  div.progress div.durring_time {
	width: 40px;
	height: 20px;
	color: #FFF;
	display: inline-block;
}
 div.progress div.durring_time {
	text-align: right;
}
.piste {
	color: #CCC;
	margin-right:5px;
}
</style>
<script src="js/vendor/jquery-1.9.0.min.js"></script>
<script src="js/audio.js	"></script>
<script src="js/player.js"></script>
<script>
/*function loadSong(elt) {
		
		$("#player").attr('src',elt.id);
		$('.play').addClass("pause");
		$('.play').removeClass("play");
		return false;
	}*/
	
	function loadSong(elt) {
		var item = jQuery(elt);
		$("li.selected_music").removeClass("selected_music");
		item.attr('class','selected_music');
		
		//$("#player").attr('src',elt.id+'.mp3');
		$("#player").currentTime = 0;
		$("#player").attr('src',elt.id);
		$('.play').addClass("pause");
		$('.play').removeClass("play");
		return false;
	}
	
</script>
</script>
</head>

<body>

<audio  id="player"  autoplay="autoplay" autobuffer>Votre navigateur n'accepte pas les mp3 </audio>
 <?php 
       
	  
	   
	   /*
	   while($res0 = $s0->fetch(PDO::FETCH_OBJ)){
		  
		 	$id_album = $res0->id_album;
		   $nom_album = stripslashes(utf8_encode($res0->titre));
		   $annee = $res0->annee_sortie;
		   $jaquette = $_MUSIC_ROOT.$res0->url_pj;
		   
		   if($annee==0) $annee="";*/
		   
		   
		?>
        <!-- ALBUM -->
        <div class="sono"><a href="http://sonotheque-hn.com/" target="_blank"><img src="img/logo_sono.png" width="92" height="33"></a></div>
<div class="music_album" id="<?php echo $id_album; ?>">
        	
  <div class="infos_album">
            <div class="img_album"><img src="<?php echo $jaquette; ?>" width="114" height="114" class="jaquette"><img src="img/play_jaquette.png" class="play_jaquette" height="50" /></div>
            <header><?php echo $nom_album; ?></header>
            <div class="artiste_album"><?php echo $annee; ?></div>
          </div>
          <div id="playlist" class="list_album" >
            <ul>
            <?php 
										
				$s = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$id_album." ORDER BY piste ASC");
				while($res = $s->fetch(PDO::FETCH_OBJ)){
					
					$id_titre = $res->id_pj;
					$titre = utf8_encode($res->nom);
					$url=$_MUSIC_ROOT.$res->url_pj;
					$id_chanson = $res->id_chanson;
					$getID3 = new getID3;
					$ThisFileInfo = $getID3->analyze($url);
					$duree = $ThisFileInfo['playtime_string'];
					//$duree=$res->duree;
					$piste = $res->piste;
					//$token = uniqid('azertyuiop',false);
					$token = $url;									
					$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
						
					if($q === FALSE) {
					
						exit('Une erreur est survenue.');
					
					}
					
					echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
				}
				
				?>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
        <div class="player">
            <div class="actions">
                  <div class="before"></div>
                  <div class="play" ></div>
                  <div class="next"></div>
                  <div class="clear"></div>
            </div>
            <div class="progress">
        		<div class="current_time"></div>
              <div class="durring_time"></div>
  		   </div>
           <div class="pres">
       	   	<a href="http://collectif-intro.com" target="_blank">Développé par Intro</a> 
           </div>
           <div style="clear:both;"></div>
        </div>
        <!-- FIN ALBUM --> 
      <?php
	  /* }*/
	  ?>  
        
      </div>
</body>
</html>
<script>
	
	
	 $(".next").click(function(){
		var next_song = $("li.select_music").next('li').attr('id');
		if(!next_song ==""){
			$(".select_music").next('li').toggleClass("select_music");
			$(".select_music").first('li').removeClass("select_music");
			$('.play').addClass("pause");
			$('.play').removeClass("play");
			//$("#player").attr('src',next_song+'.mp3');
			$("#player").attr('src',next_song);
			$("#player").load();
			$("#player").play();
		}
	});	
		
	$(".before").click(function(){
		var before_song = $("li.select_music").prev('li').attr('id');
		if(!before_song ==""){
			$(".select_music").prev('li').toggleClass("select_music");
			$(".select_music").last('li').removeClass("select_music");
			//$("#player").attr('src',before_song+'.mp3');
			$("#player").attr('src',before_song);
			$('.play').addClass("pause");
			$('.play').removeClass("play");
			$("#player").load();
			$("#player").play();
		}
	});
	
	
</script>