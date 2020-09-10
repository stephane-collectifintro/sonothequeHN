<?php require_once('header.php'); ?>

    <div id="center">

		<div class="page-header">
		  <h1>Les radios thématiques</h1>
		</div>


	    

	    <?php 
	    if ($_GET['id'] && !empty($_GET['id'])): 

	    	$id = $_GET['id'];
	    	$sql = $pdo->query("SELECT * FROM radio WHERE id_radio=".$id);
	    	$res = $sql->fetch(PDO::FETCH_OBJ);
	    	//
	    	if ($res):

				$titre = $res->titre_radio;
				$description = $res->descriptif_radio;
				$image = $res->image_radio;

	    		print "<p class='radio_description'>".$description."</p>";

	    	?>
			<article class="playlist" id="<?php print $id ?>" type="radio">
				
				<div class="row">

					<div class="col-xs-12 col-sm-3 col-md-4">
					
						<section class="information left">
							<figure class="relative album-send">
								<img src="<?php print $image; ?>" class="absolute">
								<i class="ico_play hover active"></i>
							</figure>
							<h2><?php print $titre; ?></h2>
							<div class="actions">
						
						<!-- LIKE -->
						<?php $action = "add"; $class = "like";

						$sql_favori_radio = $pdo->prepare("SELECT * FROM favori_radio WHERE id_radio=:id_radio AND id_utilisateur=:id_utilisateur");
						$sql_favori_radio->execute(array("id_radio"=>$id, "id_utilisateur"=>$_SESSION['id_utilisateur']));
						if($sql_favori_radio->fetch(PDO::FETCH_OBJ)){
							$action="remove";
							$class = "like on";
						} 
						?>					
						<i class="<?php print $class; ?>" data-type="radio" data-id="<?php print $id; ?>" data-action="<?php print $action; ?>"></i>
						<!-- FIN LIKE -->



						<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=radio"></i>
					</div>
						</section>
					
					</div>

					<div class="col-xs-12 col-sm-9 col-md-8">

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
							$nom_chanson = $res->nom;
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
								<div class="action right">
										
										<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id_chanson; ?>&page=titre"></i>

										<?php if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""): ?>

											<?php 
											$like_class = "like";
											$sql2->execute(array(':id_chanson' => $id_chanson));
											if ( $sql2->fetch(PDO::FETCH_OBJ)) $like_class = "like on";

											?>

											<i class="add" data-fancybox-type="iframe" href="ajout_playlist.php?id=<?php print $id_chanson; ?>"></i>								
											<i class="<?php print $like_class ?>" data-type="titre" data-id="<?php print $id_chanson; ?>" data-action="add"></i>
											
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

	    	else:

	    		print "Cette radio n'éxiste pas, <a href='radio.php' class='underline' titre='Retour à la liste des radios'>revenir à la liste des radios</a>";
	    	
	    	endif;
	    		

	    ?>

		

		
		
			



		<?php else: ?>



			<div class="row">
    			
	    		<ul class="radios">
		    	
			        <?php

					$sql = $pdo->query("SELECT * FROM radio WHERE online_radio=1 ORDER BY titre_radio ASC");
					$sql_favori_radio = $pdo->prepare("SELECT * FROM favori_radio WHERE id_radio=:id_radio AND id_utilisateur=:id_utilisateur");
				
					while($res=$sql->fetch(PDO::FETCH_OBJ)):
							
						$id = $res->id_radio;
						$titre = $res->titre_radio;
						$description = $res->descriptif_radio;
						$image = $res->image_radio;
						//
						$titre_url = new texte();
						$titre_url = str_replace('-','_',$titre_url->clean(strtolower($titre)));
								
												
					?>
					<div class="col-ms-6 col-sm-4">
						<li class="radio">

							<a href="radio-<?php print $id; ?>.php" title="Radio <?php print $titre; ?>">
								<figure class="relative">

									<img src="<?php print $image ?>" alt="Photo de la radio <?php print $titre ?> de la sonothèque" title="Radio <?php print $titre ?>" class="absolute">
									<!-- <i class="ico_play hover"></i> -->
									
								</figure>

								<h2><?php print $titre ?></h2>
							</a>
							
								
							<div class="actions">
								
								<!-- LIKE -->
								<?php $action = "add"; $class = "like";

								
								$sql_favori_radio->execute(array("id_radio"=>$id, "id_utilisateur"=>$_SESSION['id_utilisateur']));
								if($sql_favori_radio->fetch(PDO::FETCH_OBJ)){
									$action="remove";
									$class = "like on";
								} 
								?>					
								<i class="<?php print $class; ?>" data-type="radio" data-id="<?php print $id; ?>" data-action="<?php print $action; ?>"></i>
								<!-- FIN LIKE -->
								<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=radio"></i><!-- <i class="share"></i> -->
							</div>
							
												
						</li>
					</div>

					<?php endwhile; ?>

				
				</ul>
				
			</div>
		
    		

		<?php endif ?>
	        
	     <?php require_once('bottom.php') ?>
	   
    </div>
  
<?php require_once('footer.php'); ?>