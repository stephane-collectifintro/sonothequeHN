<?php require_once('class/getid3/getid3.php'); ?>
<?php require_once('header.php'); ?>
<?php require_once('detect_browser.php'); ?>

<?php if(!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) echo "<script>load_content('Inscription','creer_compte.php');</script>"; ?>


    <div id="center">
      <div class="titre_rose relative">
			<span class="bold">Ma</span><br>
			<span class="light">playlist</span>
		</div>

      <?php
      
      	$id = $_GET['id'];
		$sql = $pdo->query("SELECT * FROM playlist WHERE id_playlist=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		//
		if ($res):

			$titre = $res->nom_playlist;
			$image = "img/default_jaquette.png";

		?>
		<article class="playlist" id="<?php print $id ?>" type="playlist">

			<div class="row">

				<div class="col-xs-4">

					<section class="information">
						<figure class="relative album-send">
							<img src="<?php print $image; ?>">
							<i class="ico_play hover active"></i>
						</figure>
						<h2><?php print $titre; ?></h2>
						<div class="switch">

							<?php
							$publique = "";
							$sql_publique = $pdo->query('SELECT publique_playlist FROM playlist WHERE id_playlist='.$id); 
							$res = $sql_publique->fetch(PDO::FETCH_OBJ);
							if($res->publique_playlist == 1){
								$publique = "checked";
							}
							?>

							<input type="checkbox" class="cmn-toggle cmn-toggle-round" id="public_private_<?php print $id ?>" value="<?php print $id ?>" <?php print $publique ?> >
							<label for="public_private_<?php print $id ?>"></label>
							<span>Public</span>

						</div>

					</section>
					<div class="clearfix"></div>
				</div>
				<div class="col-xs-8">

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
						$nom_chanson = utf8_encode($res->nom);
						$id_pj = $res->id_pj;
						$path = $res->url_pj;
						$nom_fichier = $res->nom_pj;
						$id_chanson = $res->id_chanson;
						$artiste = $res->nom_artiste;
						$album = $res->titre;

					?>
						<li class="track" data-id="<?php print $id_chanson; ?>" id="<?php print $id_pj; ?>">
							<span class="glyphicon glyphicon-menu-hamburger left sort" aria-hidden="true"></span>
							<i class="ico_play left send"></i>
							<div class="info_track left">
								<span class="titre send"><?php print $nom_chanson; ?></span>
								<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
								<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
							</div>
							<div class="action right">
										
								<!-- <i class="share"></i> -->

								<?php if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""): ?>

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
									<i class="suppr" data-id="<?php print $id_chanson; ?>" data-playlist="<?php print $id; ?>"></i>
									
								<?php endif ?>									
								
							</div>
							<div class="clearfix"></div>
						</li>
					<?php endwhile; ?>
					</ul>
					<div class="clearfix"></div>

				</div>
			</div>

		</article>
		<?php

		else:

			print "Cette radio n'éxiste pas, <a href='radio.php' class='underline' titre='Retour à la liste des radios'>revenir à la liste des radios</a>";

		endif;

		?>
        
        
    </div>
  
<?php require_once('footer.php'); ?>