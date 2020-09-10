<?php require_once('header.php'); ?>

    <div id="center">

		<div class="page-header">
			  <h1><img src="img/playlist.svg" style="height: 26px;vertical-align: initial;"> Mes playlists</h1>
			</div>


    		<div class="row">
	    		<ul class="radios">
		    	
			        <?php
			        $sql2 = $pdo->prepare("SELECT url_pj 
								  		 FROM playlist_titre 
									     INNER JOIN chanson ON playlist_titre.id_chanson = chanson.id_chanson 
									  	 INNER JOIN album ON chanson.id_album = album.id_album
									  	 INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj
									  	 WHERE id_playlist=:id_playlist GROUP BY url_pj ORDER BY ordre_playlist_titre ASC");


					$sql = $pdo->prepare("SELECT * FROM playlist WHERE id_utilisateur=:id_utilisateur");
					$sql->execute(array("id_utilisateur"=>$_SESSION['id_utilisateur']));
				
					while($res=$sql->fetch(PDO::FETCH_OBJ)):
							
						$id = $res->id_playlist;
						$titre = $res->nom_playlist;
						$image = "img/default_jaquette.png";
						$publique = $res->publique_playlist;
						//
						$titre_url = new texte();
						$titre_url = str_replace('-','_',$titre_url->clean(strtolower($titre)));

						

						
								
												
					?>
					<div class="col-ms-6 col-sm-4">
						<li class="radio">

							<a href="ma_playlist-<?php print $id; ?>-<?php print $titre_url; ?>.php" title="Playlist <?php print $titre; ?>">
								<figure class="diapo relative">

									<?php 
									$sql2->execute(array(":id_playlist"=>$id));
									while($res2 = $sql2->fetch(PDO::FETCH_OBJ)):
										$image = $_ROOT.$_MUSIC_ROOT.$res2->url_pj;	
									?>

									<img src="<?php print $image ?>" alt="Photo de votre playlist <?php print $titre ?>" title="Playlist <?php print $titre ?>" class="absolute">

									<?php endwhile; ?>

									
								</figure>

								<h2><?php print $titre ?></h2>

							</a>
							<?php 
							$display = ($publique == 0) ? "none" : "block";
							?>
							<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=ma_playlist" style='display:<?php print $display; ?>'></i>						
							 
								
							
												
						</li>
					</div>
					<?php endwhile; ?>

				
				</ul>
			</div>
	        
	     <?php require_once('bottom.php') ?>
	   
    </div>
  
<?php require_once('footer.php'); ?>