<?php require_once('header.php'); ?>
<?php $id=$_GET['id']; ?>
<?php require_once('class/getid3/getid3.php'); ?>
<?php require_once('detect_browser.php'); ?>
  <?php
   // CLIP SEMAINE
   $date = date('Y-m-d');
   $sql = $pdo->query('SELECT * FROM top_semaine INNER JOIN album ON top_semaine.id_album = album.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE id_top_semaine="'.$id.'" LIMIT 1');
   //
   $res = $sql->fetch(PDO::FETCH_OBJ);
   $id_artiste = $res->id_artiste;
   $iframe = $res->iframe_top_semaine;
   $texte_top_semaine = utf8_encode($res->texte_top_semaine);
   $nom_artiste = $res->nom_artiste;
   $nom = stripslashes($res->nom_artiste);
   $texte = new texte();
   $nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
   $titre_album = $res->titre;
   $id_album = $res->id_album;
   $nom_album = $res->titre;


  ?>


<!-- CLIP DE LA SEMAINE -->




  <?php if($iframe!=""){ ?>

    <div class="page-header">
        <h1><a href="artiste-<?php print $id_artiste ?>-<?php print $nom_url ?>.php"><?php print $nom_artiste; ?></a></h1>
      </div>

    <div class="infos_top_semaine"><?php echo $texte_top_semaine; ?></div><br>

    <div class="embed-responsive embed-responsive-16by9">

      <?php echo $iframe; ?>

    </div>


    <script>
    $(function(){
      $('.embed-responsive iframe').addClass('embed-responsive-item');

	if (document.location.protocol === 'https:') {
    		$('iframe').each(function() {
       	 	var src = $(this).attr('src');
       	 	if (src.indexOf('http:') > -1) {
        	     	src = src.replace('http:', 'https:');
       	     	$(this).attr('src', src);
      	  	}
    		});
	}
    });
    </script>

  <?php
   }
  ?>





<!-- ALBUM DE LA SEMAINE -->






<?php if($iframe==""){ ?>


<?php

    $sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');
    $sql_favori_album = $pdo->prepare('SELECT * FROM favori_album WHERE id_album=:id_album AND id_utilisateur=:id_utilisateur LIMIT 1');



    $s0 = $pdo->query("SELECT *
                       FROM album
                       INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
                       WHERE album.id_album=".$id_album);

    $res0 = $s0->fetch(PDO::FETCH_OBJ);
        $id_artiste = $res0->id_artiste;
        $id_album = $res0->id_album;
        $nom_album = stripslashes($res0->titre);
        $annee = $res0->annee_sortie;
        $droit = $res0->gestion_droit;
        $artiste = $res0->nom_artiste;
        $nom = stripslashes($res0->nom_artiste);
        $texte = new texte();
        $nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));

        $sjaquette = $pdo->query("SELECT * FROM portfolio_sonotheque WHERE id_pj='".$res0->id_jaquette."'");
          $rjaquette = $sjaquette->fetch(PDO::FETCH_OBJ);
          $image = $_MUSIC_ROOT.$rjaquette->url_pj;

          if($annee==0) $annee="";
        ?>
      <div class="page-header">
        <h1><a href="artiste-<?php print $id_artiste ?>-<?php print $nom_url ?>.php"><?php print $nom_album; ?><br><small><?php print $artiste; ?></small></a></h1>
      </div>

      <div class="infos_top_semaine"><?php echo $texte_top_semaine; ?></div>

      <article class="playlist" id="<?php print $id_album; ?>" type="album">

        <div class="row">

          <div class="col-xs-12 col-sm-3 col-md-4">

            <section class="information">
              <figure class="relative album-send">
                <img src="<?php print $image; ?>" class="absolute">
                <?php if($droit!=3): ?>
                  <i class="ico_play hover active"></i>
                <?php endif; ?>
              </figure>
              <h2><?php print $nom_album; ?></h2>
              <h3><?php print $annee; ?></h3>

              <!-- LIKE -->


              <?php if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""){

                $action = "add"; $class = "like";

                $sql_favori_album->execute(array("id_album"=>$id_album, "id_utilisateur"=>$_SESSION['id_utilisateur']));
                if($sql_favori_album->fetch(PDO::FETCH_OBJ)){
                  $action="remove"; $class = "like on";
                }
                ?>
                <i class="<?php print $class; ?>" data-type="album" data-id="<?php print $id_album; ?>" data-action="<?php print $action; ?>"></i>
              <?php } ?>

              <!-- FIN LIKE -->

              <i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=clip_album_semaine"></i>
            </section>

          </div>

          <div class="col-xs-12 col-sm-9 col-md-8">

            <ul class="tracks" >

            <?php

                $sql = $pdo->query("SELECT *
                          FROM portfolio_sonotheque
                          INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj
                          WHERE chanson.id_album = ".$id_album."
                          ORDER BY piste ASC");


                while($res = $sql->fetch(PDO::FETCH_OBJ)):

              $duree_chanson = $res->duree;
              $nom_chanson = $res->nom;
              $id_pj = $res->id_pj;
              $path = $res->url_pj;
              $nom_fichier = $res->nom_pj;
              $id_chanson = $res->id_chanson;
              $artiste = $res->nom_artiste;
              $album = $res->titre;
              $piste = $res->piste;
              /*$token = uniqid('azertyuiop',false);
              $q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
              */
            ?>



                <li class="track" id="<?php print $id_pj; ?>">
                  <i class="ico_play left send"></i>
                  <div class="info_track left">
                    <span class="titre send"><?php print $piste.'. '.$nom_chanson; ?></span>
                    <span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
                  </div>
                  <div class="action right">

                  <i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id_chanson; ?>&page=titre"></i>

                  <?php if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""): ?>

                    <i class="add" data-fancybox-type="iframe" href="ajout_playlist.php?id=<?php print $id_chanson; ?>"></i>

                    <!-- LIKE -->
                    <?php
                    $action = "add";
                    $class = "like";
                    $sql_favori_titre->execute(array("id_chanson"=>$id_chanson, "id_utilisateur"=>$_SESSION['id_utilisateur']));
                    if($sql_favori_titre->fetch(PDO::FETCH_OBJ)){
                      $action="remove";
                      $class = "like on";
                    }
                    ?>
                    <i class="<?php print $class; ?>" data-type="titre" data-id="<?php print $id_chanson; ?>" data-action="<?php print $action; ?>"></i>
                    <!-- FIN LIKE -->

                  <?php endif ?>

                </div>

                  <div class="clearfix"></div>
                </li>


            <?php endwhile; ?>

            </ul>

          </div>

        </div>

      </article>

<?php } ?>


<?php require_once('footer.php'); ?>
