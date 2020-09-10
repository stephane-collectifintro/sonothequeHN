<?php require_once('header.php'); ?>

    <div id="center">

		<div class="page-header">
			  <h1><img src="img/radio.svg" style="height: 26px;vertical-align: initial;"> Mes radios</h1>
			</div>


    		<div class="row">
	    		<ul class="radios">
		    	
			        <?php

					$sql = $pdo->prepare("SELECT * FROM favori_radio INNER JOIN radio ON radio.id_radio = favori_radio.id_radio WHERE id_utilisateur=:id_utilisateur");
					$sql->execute(array("id_utilisateur"=>$_SESSION['id_utilisateur']));
				
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

							<a href="radio-<?php print $id; ?>-<?php print $titre_url; ?>.php" title="Radio <?php print $titre; ?>">
								<figure class="relative">

									<img src="<?php print $image ?>" alt="Photo de la radio <?php print $titre ?> de la sonothèque" title="Radio <?php print $titre ?>" class="center-cropped">
									<!-- <i class="ico_play hover"></i> -->
									
								</figure>

								<h2><?php print $titre ?></h2>
							</a>
							
								
							<div class="actions">
								
								<!-- LIKE -->
								<?php 						
									$action="remove";
									$class = "like on";
								?>					
								<i class="<?php print $class; ?>" data-type="radio" data-id="<?php print $id; ?>" data-action="<?php print $action; ?>"></i>
								<!-- FIN LIKE -->



								<!-- <i class="share"></i> -->
							</div>
							
												
						</li>
					</div>
					<?php endwhile; ?>

				
				</ul>
			</div>
	        
	     <?php require_once('bottom.php') ?>
	   
    </div>
  
<?php require_once('footer.php'); ?>