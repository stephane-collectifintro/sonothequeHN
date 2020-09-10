<?php require_once('class/getid3/getid3.php'); ?>
<?php require_once('header.php'); ?>
<?php require_once('detect_browser.php'); ?>

<?php if(!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) echo "<script>load_content('Inscription','creer_compte.php');</script>"; ?>


    <div id="center">
      <div class="page-header">
			  <h1><img src="img/coup_coeur.svg" style="height: 26px;vertical-align: initial;"> Mes coups de coeur</h1>
			</div>

     
		<article class="playlist" id="<?php print $_SESSION['id_utilisateur'] ?>" type="coup_coeur">

			<div class="row">

				<div class="col-xs-12">

					<ul class="tracks sortable" data-playlist='<?php print $_SESSION['id_utilisateur'] ?>'>

					<?php 				
					$sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');


				    $sql = $pdo->query("SELECT * 
										FROM favori_titre 
										INNER JOIN chanson ON chanson.id_chanson=favori_titre.id_chanson
										INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
										INNER JOIN album ON chanson.id_album = album.id_album
										INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
										WHERE id_utilisateur=".$_SESSION['id_utilisateur']);

				 
				    while($res = $sql->fetch(PDO::FETCH_OBJ)):
						
						$id_chanson = $res->id_chanson;
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
							<!-- <span class="glyphicon glyphicon-menu-hamburger left sort" aria-hidden="true"></span> -->
							<i class="ico_play left send"></i>
							<div class="info_track left">
								<span class="titre send"><?php print $nom_chanson; ?></span>
								<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
								<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
							</div>
							<div class="action right">
										
									<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id_chanson; ?>&page=titre"></i>

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
																	
								
							</div>
							<div class="clearfix"></div>
						</li>
					<?php endwhile; ?>
					</ul>
					<div class="clearfix"></div>

				</div>
			</div>

		</article>
       
        
    </div>
  
<?php require_once('footer.php'); ?>