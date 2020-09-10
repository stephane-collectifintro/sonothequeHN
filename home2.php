<?php require_once('init.php'); ?>
<?php require_once('header.php'); ?>
    <div id="center">
   <?php
   $date = date('Y-m-d');
   
   
   // CLIP SEMAINE
   $sql = $pdo->query('SELECT * FROM top_semaine INNER JOIN album ON top_semaine.id_album = album.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE date_debut_top_semaine<="'.$date.'" AND date_fin_top_semaine>="'.$date.'" AND iframe_top_semaine!="" LIMIT 1');
   $res = $sql->fetch(PDO::FETCH_OBJ);
   //
   $id_top = $res->id_top_semaine;
   $id_album = $res->id_album;
   $id_iframe = $res->id_iframe;
   $plateforme = $res->plateforme_top_semaine;
   $id_artiste = $res->id_artiste;
   $nom_artiste = $res->nom_artiste;
   $texte = new texte();
   $nom_artiste = str_replace('-','_',strtolower($texte->clean($nom_artiste)));
   
   if($plateforme=='youtube'){
   
	   if(file_exists("http://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg")){ 
			$image = "http://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg"; 
		}else{ 
			$image = "http://img.youtube.com/vi/".$id_iframe."/0.jpg"; 
		}
	
   }
   
   if($plateforme=='dailymotion'){
   
	   if(file_exists("http://www.dailymotion.com/thumbnail/video/".$id_iframe)){ 
			$image = "http://www.dailymotion.com/thumbnail/video/".$id_iframe; 
		}else{ 
			$image = "http://www.dailymotion.com/thumbnail/video/".$id_iframe; 
		}
	
   }
	if($plateforme=='vimeo'){
		$thumb = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$id_iframe.'.php')); 
		$image = $thumb[0]['thumbnail_large'];
		
	}
   
   // ALBUM SEMAINE
   $sql = $pdo->query('SELECT * FROM top_semaine INNER JOIN album ON top_semaine.id_album = album.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj  WHERE date_debut_top_semaine<="'.$date.'" AND date_fin_top_semaine>="'.$date.'" AND iframe_top_semaine="" LIMIT 1');
   $res = $sql->fetch(PDO::FETCH_OBJ);
   //
   $id_top2 = $res->id_top_semaine;
   $id_album2 = $res->id_album;
   $id_artiste2 = $res->id_artiste;
   $nom_artiste2 = $res->nom_artiste;
   $texte = new texte();
   $nom_artiste2 = str_replace('-','_',strtolower($texte->clean($nom_artiste2)));
   $jaquette = $_MUSIC_ROOT.$res->url_pj;
   
   
   // INTERVIEW
   $sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste WHERE date_debut_interview<="'.$date.'" AND date_fin_interview>="'.$date.'" LIMIT 1');
   $res = $sql->fetch(PDO::FETCH_OBJ);
   //
   $id_interview3 = $res->id_interview;
   $id_artiste3 = $res->id_artiste;
   $nom_artiste_interview = $res->nom_artiste;
   $photo_interview3 = $res->photo_interview;
   $align_photo_interview3 = $res->align_photo_interview;
   $texte = new texte();
   $nom_artiste3 = str_replace('-','_',strtolower($texte->clean($nom_artiste_interview)));
   
   ?>
   
    <div id="home">


      <a href="clip_album_semaine-<?php echo $id_top; ?>.php" title="Le clip de la semaine">
      <article style="background-image:url(<?php echo $image; ?>);">
      	
        <div class="titre_rose">
        	<span class="bold">le clip</span><br>
            <span class="light">de la semaine</span>
        </div>
        
        <img src="img/play_jaquette.png" class="play_jaquette"/>
        
      </article>
      </a>
      
      <article><a rel="link"href="partager_savoir.php"><img src="img/part.png" width="114" height="243"></a></article>
      
      
      <article style="background-image:url(<?php echo $jaquette; ?>)">
      	<a href="clip_album_semaine-<?php echo $id_top2; ?>.php" title="L'album de la semaine">
      	<div class="titre_rose">
        	<span class="bold">l'album</span><br>
            <span class="light">de la semaine</span>
        </div>
        <!--<div class="link">Voir la fiche de l'artiste</div>-->
        <img src="img/play_jaquette.png" class="play_jaquette"/>
        </a>
      </article>
    
      
      <article style="background-image:url(<?php echo $photo_interview3; ?>); background-position:<?php echo $align_photo_interview3; ?>;">
      <a href="interview-<?php echo $id_interview3; ?>.php" title="L'interview de <?php echo utf8_encode($nom_artiste_interview); ?>">
      	<div class="titre_rose">
        	<span class="bold">interview</span><br>
            <span class="light">de <?php echo utf8_encode($nom_artiste_interview); ?></span>
        </div>
        <!--<div class="link">Voir la fiche de l'artiste</div>-->
      </a>
      </article>
      
      <article style="background-image:url(img/image_maj.png);">
      	<a href="mise_a_jour_artiste.php" title="Mise à jour artiste"><div class="titre_rose">
        	<span class="bold">nouvelles</span><br>
            <span class="light">mise à jour artistes</span>
        </div></a>
      </article>

    </div>
      
      <?php require_once('bottom.php'); ?>
    </div>
  
<?php require_once('footer.php'); ?> 




