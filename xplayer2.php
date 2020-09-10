<?php 
require_once('init.php');
require_once('cn.php');
require_once('class/getid3/getid3.php'); 
require_once('detect_browser.php');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css2/styles.css">
<style type="text/css">
	body{
		background: #FFF!important;
		margin: 40px 0 50px 0;
		overflow: hidden;
	}
	.container, .container-fluid{
		background: #FFF;
		margin: 0;
		padding: 0;
	}
	article{
		padding: 0!important;
		margin: 0!important;
	}
	.row{
		padding: 0;
		margin: 0;
	}
	[class^=col-]{
		padding: 0;
		margin: 0;
	}

	ul.tracks{
		overflow: auto;
		height:100%;
	}
	h4{
		position: fixed;
		top: 0;
		padding: 0 0 0 15px;
	}
	footer div.player div.playlist {
		display: none;
	}
	#logo{
		position: absolute;
	    top: 10px;
	    right: 18px;
	    height: 21px;
	}
	.play{
		margin: -5px 7px 0 7px !important;
	}

	footer div.player div.actions {
	    
	    width: auto !important;
	    padding: 15px 20px 0 20px !important;
	}
	figure{
		padding: 0 !important;
		margin: 0 !important;
	}
	figure .diapo{
		width: 100%;
		height: auto;
	}
	figure .diapo img{
		width: 100%;
		height: auto;
	}




</style>

   
    
    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plugins.js"></script>    
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="js/history.js"></script>
		<script src="js/audio.js"></script>
		<script src="js/player.js"></script>
    <script src="js/login.js"></script>
		<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
    <script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>




<div class="container-fluid" style="background: #FFF;">

<img src="img/logo-small.svg" height="20px" id="logo">
<?php


$id = $_GET['id'];
$page = $_GET['p'];



?>
<!-- CLIP ALBUM SEMAINE -->

  <?php
if ($page=="clip_album_semaine"){
   // CLIP SEMAINE
   $date = date('Y-m-d');
   $sql = $pdo->query('SELECT * FROM top_semaine INNER JOIN album ON top_semaine.id_album = album.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE id_top_semaine="'.$id.'" LIMIT 1');
   //
    $res = $sql->fetch(PDO::FETCH_OBJ);
   $id_artiste = $res->id_artiste;
   $nom_artiste = $res->nom_artiste;
   $nom = stripslashes($res->nom_artiste);;
   $titre_album = $res->titre;
   $id_album = $res->id_album;
	

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


<?php
}
  ?>

<!-- ALBUM -->



<?php

if ($page=="album") {
	
       	
       	$sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');
   		$sql_favori_album = $pdo->prepare('SELECT * FROM favori_album WHERE id_album=:id_album AND id_utilisateur=:id_utilisateur LIMIT 1');


        $s0 = $pdo->query("SELECT * 
        				   FROM album 
        				   INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
        				   WHERE album.id_album=".$id);

		$res0 = $s0->fetch(PDO::FETCH_OBJ);

		   		$id_album = $res0->id_album;
				$nom_album = stripslashes($res0->titre);
				$annee = $res0->annee_sortie;
				$droit = $res0->gestion_droit;
				$artiste = $res0->nom_artiste;

				$sjaquette = $pdo->query("SELECT * FROM portfolio_sonotheque WHERE id_pj='".$res0->id_jaquette."'");
			   	$rjaquette = $sjaquette->fetch(PDO::FETCH_OBJ);
			   	$image = $_MUSIC_ROOT.$rjaquette->url_pj;
			   	
			   	if($annee==0) $annee="";
		   	?>
			<h4><?php print $nom_album; ?> - <?php print $artiste; ?> <small>(<?php print $annee; ?>)</small></h4>
			<article class="playlist" id="<?php print $id_album; ?>" type="album">

				<div class="row">

					<div class="col-xs-5">
						
						<section class="information">
							<figure>
								<img src="<?php print $image; ?>">
							</figure>
							

						
						</section>

					</div>

					<div class="col-xs-7">

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

							<?php if($droit!=3): ?>

								<li class="track" id="<?php print $id_pj; ?>">
									<i class="ico_play left send"></i>
									<div class="info_track left">
										<span class="titre send"><?php print $piste.'. '.$nom_chanson; ?></span>
										<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
									</div>									
									<div class="clearfix"></div>
								</li>
							
							<?php else: ?>
								
								<li class="track disable">
									<!-- <i class="ico_play left"></i> -->
									<div class="info_track left">
										<span class="titre"><?php print $piste.'. '.$nom_chanson; ?></span>
										<span class="duree"><?php print $duree_chanson; ?></span>
									</div>
									<div class="clearfix"></div>
								</li>


							<?php endif; //fin if autorisation ?>

						<?php endwhile; ?>

						</ul>

					</div>

				</div>

			</article>

<?php } ?>




<!-- TITRE -->



<?php 
if ($page=="titre") {

		$sql = $pdo->query("SELECT * 
        					FROM portfolio_sonotheque 
        					INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj
        					INNER JOIN album ON album.id_album = chanson.id_album
        					INNER JOIN artiste ON album.id_artiste = artiste.id_artiste 
        					WHERE chanson.id_chanson = ".$id);

     
        $res = $sql->fetch(PDO::FETCH_OBJ);
			
		$duree_chanson = $res->duree;
		$nom_chanson = $res->nom;
		$id_pj = $res->id_pj;
		$path = $res->url_pj;
		$nom_fichier = $res->nom_pj;
		$id_chanson = $res->id_chanson;
		$artiste = $res->nom_artiste;
		$id_album = $res->id_album;
		$album = $res->titre;
		$piste = $res->piste;
		/*$token = uniqid('azertyuiop',false);
		$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
		*/

		$sql = $pdo->query("SELECT * 
        					FROM portfolio_sonotheque 
        					INNER JOIN album ON album.id_jaquette = portfolio_sonotheque.id_pj
        					WHERE album.id_album = ".$id_album);

     
        $res = $sql->fetch(PDO::FETCH_OBJ);
        $image = $_ROOT.$_MUSIC_ROOT.$res->url_pj;


		?>

		<h4><?php print $nom_chanson; ?><small><?php print $album; ?> - <?php print $artiste; ?></small></h4>
		<article class="playlist" id="<?php print $id; ?>" type="track">

			<div class="row">

				<div class="col-xs-5">
					
					<section class="information">
						<figure>
							<img src="<?php print $image; ?>">
						</figure>					
					</section>

				</div>

				<div class="col-xs-7">

			<ul class="tracks " >

			


				<li class="track" id="<?php print $id_pj; ?>">
					<i class="ico_play left send"></i>
					<div class="info_track left">
						<span class="titre send"><?php print $nom_chanson; ?></span>
						<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
						<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
					</div>
					
					<div class="clearfix"></div>
				</li>
				

			</ul>
			</div>
			</div>

		</article>


<?php
}
?>













<?php 
if ($page=="radio") {

		$sql = $pdo->query("SELECT * FROM radio WHERE id_radio=".$id);
	    	$res = $sql->fetch(PDO::FETCH_OBJ);
	    	//
	    	if ($res):

				$titre = $res->titre_radio;
				$description = $res->descriptif_radio;
				$image = $res->image_radio;

	    	?>
	    	<h4><?php print $titre ?> <small>Radio de la Sonotheque Normandie</small></h4>
			<article class="playlist" id="<?php print $id ?>" type="radio">
				
				<div class="row">

					<div class="col-xs-5">
						
						<section class="information">
							<figure>
								<img src="<?php print $image; ?>">
							</figure>						
						</section>

					</div>

					<div class="col-xs-7">

						<ul class="tracks" >
						

						<?php 


				        $sql = $pdo->query("SELECT * 
											FROM `radio_titre` 
											INNER JOIN chanson ON chanson.id_chanson=radio_titre.id_chanson
											INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
											INNER JOIN album ON chanson.id_album = album.id_album
											INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
											WHERE id_radio=".$id." ORDER BY ordre_radio_titre ASC");

				        $sql2 = $pdo->prepare("SELECT * FROM favori_titre WHERE id_chanson = :id_chanson AND id_utilisateur =".$_SESSION['id_utilisateur']);
				     
				        while($res = $sql->fetch(PDO::FETCH_OBJ)):
							
							$duree_chanson = $res->duree;
							$nom_chanson = utf8_encode($res->nom);
							$id_pj = $res->id_pj;
							$path = $res->url_pj;
							$nom_fichier = $res->nom_pj;
							$id_chanson = $res->id_chanson;
							$artiste = $res->nom_artiste;
							$album = $res->titre;


						?>
							<li class="track" id="<?php print $id_pj; ?>">
								<i class="ico_play left send"></i>
								<div class="info_track left">
									<span class="titre send"><?php print $nom_chanson; ?></span>
									<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
									<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
								</div>
								<div class="clearfix"></div>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>

				</div>

			</article>
	    	<?php

	    	else:

	    		print "Cette radio n'éxiste pas, <a href='radio.php' class='underline' titre='Retour à la liste des radios'>revenir à la liste des radios</a>";
	    	
	    	endif;
	    		

	    ?>


<?php
}
?>




<!-- PLAYLIST -->





<?php 
if ($page=="ma_playlist") {

		$sql = $pdo->query("SELECT * FROM playlist INNER JOIN utilisateur ON playlist.id_utilisateur = utilisateur.id_utilisateur WHERE id_playlist=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		//
		$titre = $res->nom_playlist;
		$image = "img/default_jaquette.png";
		$user_name = $res->prenom_utilisateur." ".$res->nom_utilisateur;
		$publique = $res->publique_playlist;
		//
		if ($publique != 0):		


			$sql2 = $pdo->prepare("SELECT url_pj 
				  		 		   FROM playlist_titre 
				     			   INNER JOIN chanson ON playlist_titre.id_chanson = chanson.id_chanson 
							  	   INNER JOIN album ON chanson.id_album = album.id_album
							  	   INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj
							  	   WHERE id_playlist=:id_playlist GROUP BY url_pj ORDER BY ordre_playlist_titre ASC");

		?>

		<h4><?php print $titre ?> <small>par <?php print $user_name; ?></small></h4>
		<article class="playlist" id="<?php print $id ?>" type="playlist">

			<div class="row">

					<div class="col-xs-5">
						
						<section class="information">
							<figure class="relative">
							<div class="diapo absolute" >
								<?php 
								$sql2->execute(array(":id_playlist"=>$id));
								while($res2 = $sql2->fetch(PDO::FETCH_OBJ)):
									$image = $_ROOT.$_MUSIC_ROOT.$res2->url_pj;	
								?>
								<img src="<?php print $image ?>" alt="Photo de votre playlist <?php print $titre ?>" title="Playlist <?php print $titre ?>" class="absolute">
								<?php endwhile; ?>
							</div>
							</figure>
						

						</section>
					<div class="clearfix"></div>
				</div>
				<div class="col-xs-7">

					<ul class="tracks sortable" data-playlist='<?php print $id ?>'>

					<?php 				
					$sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');

				    $sql = $pdo->query("SELECT * 
										FROM `playlist_titre` 
										INNER JOIN chanson ON chanson.id_chanson=playlist_titre.id_chanson
										INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
										INNER JOIN album ON chanson.id_album = album.id_album
										INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
										WHERE id_playlist=".$id."
										ORDER BY ordre_playlist_titre ASC");

				 
				    while($res = $sql->fetch(PDO::FETCH_OBJ)):
						
						$duree_chanson = $res->duree;
						$nom_chanson = $res->nom;
						$id_pj = $res->id_pj;
						$path = $res->url_pj;
						$nom_fichier = $res->nom_pj;
						$id_chanson = $res->id_chanson;
						$artiste = $res->nom_artiste;
						$album = $res->titre;

					?>
						<li class="track" data-id="<?php print $id_chanson; ?>" id="<?php print $id_pj; ?>">
							<i class="ico_play left send"></i>
							<div class="info_track left">
								<span class="titre send"><?php print $nom_chanson; ?></span>
								<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
								<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
							</div>
							
							<div class="clearfix"></div>
						</li>
					<?php endwhile; ?>
					</ul>
					<div class="clearfix"></div>

				</div>
			</div>

		</article>

	<?php endif; ?>


<?php } ?>


</div>

<?php require_once("player.php"); ?>










