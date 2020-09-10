<?php require_once('header.php'); ?>

    <div id="center">

		<div class="page-header">
			  <h1><img src="img/album.svg" style="height: 26px;vertical-align: initial;"> Mes albums</h1>
			</div>


    		<div class="row">
	    		<ul class="radios">
		    	
			        <?php

					$sql = $pdo->prepare("SELECT * 
										  FROM favori_album 
										  INNER JOIN album ON album.id_album = favori_album.id_album
										  INNER JOIN artiste ON album.id_artiste = artiste.id_artiste 
										  INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj
										  WHERE id_utilisateur=:id_utilisateur");

					$sql->execute(array("id_utilisateur"=>$_SESSION['id_utilisateur']));
				
					while($res=$sql->fetch(PDO::FETCH_OBJ)):
							
						$id = $res->id_album;
						$titre = $res->titre;
						$artiste = $res->nom_artiste;

						$image = $_ROOT.$_MUSIC_ROOT.$res->url_pj;
						//
						$titre_url = new texte();
						$titre_url = str_replace('-','_',$titre_url->clean(strtolower($titre)));
								
												
					?>
					<div class="col-ms-6 col-sm-4">
						<li class="radio">

							<a href="album-<?php print $id; ?>-<?php print $titre_url; ?>.php" title="Album <?php print $titre; ?>">
								<figure class="relative">

									<img src="<?php print $image ?>" alt="Pochette de l'album <?php print $titre ?> " title="Album <?php print $titre ?>" class="center-cropped">
									<!-- <i class="ico_play hover"></i> -->
									
								</figure>
								
								<h2><?php print $titre; ?><small><?php print $artiste; ?></small></h2>
							</a>
							
								
							<div class="actions">
								
								<!-- LIKE -->
								<?php 						
									$action="remove";
									$class = "like on";
								?>					
								<i class="<?php print $class; ?>" data-type="album" data-id="<?php print $id; ?>" data-action="<?php print $action; ?>"></i>
								<!-- FIN LIKE -->



								<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=album"></i>



							</div>
							
												
						</li>
					</div>
					<?php endwhile; ?>

				
				</ul>
			</div>
	        
	     <?php require_once('bottom.php') ?>
	   
    </div>
  
<?php require_once('footer.php'); ?>