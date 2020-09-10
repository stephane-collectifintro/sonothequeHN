
<?php require_once('header.php'); ?>

<?php if(!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) echo "<script>load_content('Inscription','creer_compte.php');</script>"; ?>


    <div id="center">
      

      <?php
      
      	$id = $_GET['id'];
		$sql = $pdo->query("SELECT * FROM playlist INNER JOIN utilisateur ON playlist.id_utilisateur = utilisateur.id_utilisateur WHERE id_playlist=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		//
		$titre = $res->nom_playlist;
		$image = "img/default_jaquette.png";
		$id_user = $res->id_utilisateur;
		$user_name = $res->prenom_utilisateur." ".$res->nom_utilisateur;
		$publique = $res->publique_playlist;
		//
		if ($id_user==$_SESSION['id_utilisateur'] || $publique != 0):

			

			$sql2 = $pdo->prepare("SELECT url_pj 
				  		 		   FROM playlist_titre 
				     			   INNER JOIN chanson ON playlist_titre.id_chanson = chanson.id_chanson 
							  	   INNER JOIN album ON chanson.id_album = album.id_album
							  	   INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj
							  	   WHERE id_playlist=:id_playlist GROUP BY url_pj ORDER BY ordre_playlist_titre ASC");

		?>


		<div class="page-header">
		  <h1>
		  	<img src="img/playlist.svg" style="height: 26px;vertical-align: initial;"> <span><?php print $titre; ?></span>
		  	<?php if($id_user!=$_SESSION['id_utilisateur']){ ?><small style="margin: 0 0 0 10px; font-size: 0.4em;"> par <?php print $user_name; ?></small><?php } ?>
		  </h1>
		</div>


		<article class="playlist" id="<?php print $id ?>" type="playlist">

			<div class="row">

				<div class="col-xs-4">

					<section class="information">
						<figure class="relative album-send">
							<div class="diapo absolute">
								<?php 
								$sql2->execute(array(":id_playlist"=>$id));
								while($res2 = $sql2->fetch(PDO::FETCH_OBJ)):
									$image = $_ROOT.$_MUSIC_ROOT.$res2->url_pj;	
								?>
								<img src="<?php print $image ?>" alt="Photo de votre playlist <?php print $titre ?>" title="Playlist <?php print $titre ?>" class="absolute">
								<?php endwhile; ?>
							</div>
							<i class="ico_play hover active"></i>
						</figure>

						<h2><?php print $titre; ?></h2>

						<div id="modif_playlist_form" style="display: none;">
							<input type="text" name="modif-playlist-name" value="<?php print $titre; ?>" style="padding:5px;" /> <button type="button" class="btn btn-primary btn-xs modif-playlist" data-id="<?php print $id; ?>">Modifier</button></i>
						</div>

						<?php 
						$display = ($publique == 0) ? "none" : "block";
						?>
						<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=ma_playlist" style='display:<?php print $display; ?>'></i>


						
						<?php if($id_user==$_SESSION['id_utilisateur']){ ?>
						<div class="switch">

							<?php
							$publique = "";
							$label_publique = "Privé";
							$sql_publique = $pdo->query('SELECT publique_playlist FROM playlist WHERE id_playlist='.$id); 
							$res = $sql_publique->fetch(PDO::FETCH_OBJ);
							if($res->publique_playlist == 1){
								$publique = "checked";
								$label_publique = "Public";
							}
							?>
							
							<input type="checkbox" class="cmn-toggle cmn-toggle-round" id="public_private_<?php print $id ?>" value="<?php print $id ?>" <?php print $publique ?> >
							<label for="public_private_<?php print $id ?>"></label>
							<span><?php print $label_publique; ?></span>
		

						</div>

						<?php } ?>

						<!-- modif & suppr playlist -->
						<br>
						<button type="button" class="btn btn-danger btn-xs suppr-playlist" data-id="<?php print $id; ?>">Supprimer</button>

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
						$nom_chanson = $res->nom;
						$id_pj = $res->id_pj;
						$path = $res->url_pj;
						$nom_fichier = $res->nom_pj;
						$id_chanson = $res->id_chanson;
						$artiste = $res->nom_artiste;
						$album = $res->titre;

					?>
						<li class="track" data-id="<?php print $id_chanson; ?>" id="<?php print $id_pj; ?>">
							<?php if($id_user==$_SESSION['id_utilisateur']){ ?><span class="glyphicon glyphicon-menu-hamburger left sort" aria-hidden="true"></span><?php } ?>
							<i class="ico_play left send"></i>
							<div class="info_track left">
								<span class="titre send"><?php print $nom_chanson; ?></span>
								<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
								<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
							</div>
							<div class="action right">
										
								<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id_chanson; ?>&page=titre"></i>

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
									<?php if($id_user==$_SESSION['id_utilisateur']){ ?><i class="suppr" data-id="<?php print $id_chanson; ?>" data-playlist="<?php print $id; ?>"></i><?php } ?>
									
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
		
        <?php endif; ?>
        
    </div>
  
<?php require_once('footer.php'); ?>