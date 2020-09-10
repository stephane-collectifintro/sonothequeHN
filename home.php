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
   //$nom_artiste = str_replace('-','_',strtolower($texte->clean($nom_artiste)));

   if($plateforme=='youtube'){

	   if(file_exists("https://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg")){
			$image = "https://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg";
		}else{
			$image = "https://img.youtube.com/vi/".$id_iframe."/0.jpg";
		}

   }

   if($plateforme=='dailymotion'){

	   if(file_exists("https://www.dailymotion.com/thumbnail/video/".$id_iframe)){
			$image = "https://www.dailymotion.com/thumbnail/video/".$id_iframe;
		}else{
			$image = "https://www.dailymotion.com/thumbnail/video/".$id_iframe;
		}

   }
	if($plateforme=='vimeo'){
		$thumb = unserialize(file_get_contents('https://vimeo.com/api/v2/video/'.$id_iframe.'.php'));
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
   //$nom_artiste2 = str_replace('-','_',strtolower($texte->clean($nom_artiste2)));
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


   //mise a jour artiste
   $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-14-date('N')+1, date('Y')));

   //---ARTISTE
   $nom_maj_artiste = array();
   $sql = $pdo->query("SELECT * FROM artiste WHERE date_maj_artiste>='".$date."' LIMIT 3" );
   if($sql->rowCount()>0){
    while($res=$sql->fetch(PDO::FETCH_OBJ)){
      $nom_maj_artiste[] = stripslashes($res->nom_artiste);
    }
   }


   ?>

    <div id="home">

      <?php
      $sql = $pdo->query("SELECT * FROM radio WHERE online_radio!=0");
      if ($sql->fetch(PDO::FETCH_OBJ)): ?>

      <div class="row">
        <a href="radio.php">
			<div class="col-xs-12"><img src="img/radio_home.jpg" width="100%">
          		<div class="titre_rose">
            		<span class="bold">Les Radios</span><br>
              		<span class="light">thématiques</span>
          		</div>
		    </div>
		</a>
      </div>

      <?php endif ?>

      <div class="row">

        <div class="col-sm-10 col-xs-12">

          <a href="clip_album_semaine-<?php echo $id_top; ?>.php" title="Le clip de la semaine">
            <article id="clip_semaine" style="background-image:url(<?php echo $image; ?>);">

              <div class="titre_rose">
              	<span class="bold">le clip</span><br>
                  <span class="light">de <?php echo $nom_artiste; ?></span>
              </div>

              <i class="ico_play hover"></i>

            </article>
          </a>

        </div>


        <div class="col-sm-2 hidden-xs">

          <a rel="link"href="partager_savoir.php">
            <article id="savoir" style="background-image:url(img/savoir.svg)" ></article>
          </a>

        </div>


        <div class="col-sm-6 col-xs-12">

          <a href="clip_album_semaine-<?php echo $id_top2; ?>.php" title="L'album de la semaine">

            <article id="album_semaine" style="background-image:url(<?php echo $jaquette; ?>)">


            	<div class="titre_rose">
              	<span class="bold">l'album</span><br>
                  <span class="light">de <?php echo $nom_artiste2; ?></span>
              </div>



              <i class="ico_play hover"></i>

            </article>

          </a>



          <a href="mise_a_jour_artiste.php" title="Mises à jour artiste" style="display:block; width:100%; height: 100%;">

            <article id="maj_semaine" style="background-image:url(img/image_maj.png);">

              <div class="titre_rose">
                <span class="bold">mises à jour de </span><br>
                  <span class="light"> <?php
                  foreach($nom_maj_artiste as $result) {
                      echo $result.', ';
                  }?>
                 </span>
              </div>

            </article>
          </a>


        </div>

        <div class="col-sm-6 col-xs-12">

          <a href="interview-<?php echo $id_interview3; ?>.php" title="L'interview de <?php echo $nom_artiste_interview; ?>">

            <article id="interview_semaine" style="background-image:url(<?php echo $photo_interview3; ?>); background-position:<?php echo $align_photo_interview3; ?>;">

              	<div class="titre_rose">
                	<span class="bold">interview</span><br>
                    <span class="light">de <?php echo $nom_artiste_interview; ?></span>
                </div>
                <!--<div class="link">Voir la fiche de l'artiste</div>-->


            </article>

          </a>

        </div>

      </div>

      <?php require_once('bottom.php'); ?>
    </div>
  </div>
<?php require_once('footer.php'); ?>
