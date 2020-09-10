
<?php $id=$_GET['id']; ?>
<?php require_once('header.php'); ?>
<?php require_once('class/getid3/getid3.php'); ?>

<?php require_once('detect_browser.php'); ?>


<script>

var id_artiste = <?php echo $id; ?>;
$(function(){
	$.post("compteur.php", { type: "artiste", id:id_artiste },function(data){  console.log(data);} );
});


</script>


  	<?php

		$sql = $pdo->query("SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo WHERE artiste.id_artiste=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		//
		$nom_artiste = stripslashes($res->nom_artiste);
		$bio_artiste = stripslashes($res->bio_artiste);
		$url_site = stripslashes($res->url_site_web);
		$url_site_2 = stripslashes($res->url_site_web_2);
		$image_artiste = $_ROOT.$_MUSIC_ROOT.$res->url_pj;

		if($res->date_creation=="1960-01-01"){
			$date_creation = "Inconnu";
		}else{
			$date_creation = date("d/m/Y", strtotime($res->date_creation));
		}
		$date_fin = date("d/m/Y", strtotime($res->date_fin));
		if($res->ville==""){
			$ville = "Inconnu";
		}else{
			$ville = stripslashes($res->ville);
		}
	?>





    <figure id="photoartiste" class="overflow-hidden">
    	<div class="nom_artiste"><?php echo $nom_artiste; ?></div>
    	<div class="diapo">
        	<?php if($res->id_photo!=0 && is_readable($image_artiste)){ ?>
            <div class="image overflow-hidden"><img src="<?php echo $image_artiste; ?>" title="<?php echo $nom_artiste; ?>" alt="<?php echo $nom_artiste; ?>" width="100%" class="center-cropped" /></div>
            <?php
			}
			$sql = $pdo->query("SELECT * FROM media WHERE id_artiste=".$id);
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				$photo = $_ROOT.$res->path_media;
				$pct = $res->y_align_media;
			?>
            <div class="image overflow-hidden">
            	<img src="<?php echo $photo; ?>" title="<?php echo $nom_artiste; ?>" alt="<?php echo $nom_artiste; ?>" width="100%" class="absolute" style="top:<?php print $pct; ?>%" />
            </div>
            <?php
			}
			?>
   		</div>
   	</figure>

      <div class="infos_artiste"><div class="label">Ville</div><div class="texte"><?php echo $ville; ?></div><div class="clear"></div></div>
      <div class="infos_artiste"><div class="label">Création</div><div class="texte"><?php echo $date_creation; ?></div><div class="clear"></div></div>
      <i class="share pull-right" data-fancybox-type="iframe" href="share.php?id=<?php print $id; ?>&page=artiste" style="height: 18px; width: 25px; margin: 13px 0 0 0;"></i>


      <?php if($date_fin!="01/01/1960"){ ?><div class="infos_artiste"><div class="label">Fin</div><div class="texte"><?php echo $date_fin; ?></div><div class="clear"></div></div><?php } ?>
      <div class="clear"></div>
      <div class="description crop"><div class="content"><?php echo $bio_artiste; ?></div><div class="gradient"></div></div>
      <i class="arrow-bottom"></i>
      <div class="link">
        <ul>
			<?php
				if (preg_match('#^https://[w-]+[w.-]+.[a-zA-Z]{2,6}#i', $url_site)) {
    					$url_site = $url_site;
				} else {
   				 		$url_site = 'http://'.$url_site;
				}
			?>
          <li><a href="<?php echo $url_site; ?>" target="_blank"><?php echo $url_site; ?></a></li>
          <li><a href="<?php echo $url_site_2; ?>" target="_blank"><?php echo $url_site_2; ?></a></li>
        </ul>
      </div>
      <div class="list-tag">
        <ul class="list-inline">
            <?php
								$tags = [];
                $sql = $pdo->query("SELECT id_tag FROM item_tag WHERE id_item=".$id);

                	while ($res = $sql->fetch(PDO::FETCH_OBJ)): ?>
												<?php array_push($tags ,$res->id_tag); ?>
                        <?php $sql2 = $pdo->query("SELECT tag_name FROM tags WHERE tag_id=".$res->id_tag); ?>
                        <?php $res2 = $sql2->fetch(PDO::FETCH_OBJ); ?>
                        <?php $url = "recherche.php?search=".$res2->tag_name."&action=all"; ?>
                        <li><b><a href="<?php print $url  ?>">#<?php print $res2->tag_name; ?></a></b></li>
                    <? endwhile; ?>
        </ul>
      </div>
<?php 	if(!empty($tags)) { ?>
	<?php



		$rand_keys = array_rand($tags,1) ;
		$sqlSug= $pdo->query("SELECT id_item FROM item_tag WHERE id_tag=".$tags[$rand_keys]." AND id_item != ".$id." ORDER BY RAND() LIMIT 1");
		$resSug = $sqlSug->fetch(PDO::FETCH_OBJ);
		if(!empty($resSug)){
			$sqlUser = $pdo->query("SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo WHERE id_artiste=".$resSug->id_item);

			$resUser = $sqlUser->fetch(PDO::FETCH_OBJ);
			$image_artiste2 = $_ROOT.$_MUSIC_ROOT.$resUser->url_pj;
			
		?>
			<div class="discographie">

				
				<header  style="margin-bottom:20px">Suggestion</header>
				<?php 
					 $texte = new texte();
					 $nom_artiste_sug = stripslashes($resUser->nom_artiste); 
       				 $nom_artiste_sug = str_replace('-','_',$texte->clean(strtolower($nom_artiste_sug)));
					
				
				?> 
				<h2 class="suggestion" style="margin-bottom:10px"><a href="artiste-<?php print $resUser->id_artiste; ?>-<?php print $nom_artiste_sug; ?>.php"><?php echo $resUser->nom_artiste; ?></a></h2>
				
				
				<figure class="relative album-send">
					<?php if($resUser->id_photo!=0 ): ?>
					<img src="<?php echo $image_artiste2 ; ?>" class="img-responsive" height="210" width="210">
				<?php else:?>
					<?php
						$sql2 = $pdo->query("SELECT * FROM media WHERE id_artiste=".$resSug->id_item." LIMIT 1");

						while($res = $sql2->fetch(PDO::FETCH_OBJ)){
							$photo2 = $_ROOT.$res->path_media;

						//
					 ?>
					 <img src="<?php echo $photo2 ?>" class="img-responsive" height="210" width="210">
					 <?php } ?>
					<?php endif; ?>
				</figure>
				
			</div>
	<?php } ?> 
<?php } ?>
      <div class="red_line"></div>


      <!--FACEBOOK LIKE-->
      <!--


    <!--  <div class="fb-like left" data-href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false" style="height:40px;"></div>&nbsp;&nbsp;&nbsp;
      -->
       <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
      <!--TWITTER LIKE-->
      <!--
      <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
	  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->

        <!--<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&via=sonotheque&text=google" style="width:115px; height:21px;"></iframe>-->
        <?php if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""){ ?>
        	<div class="bouton right various" data-fancybox-type="iframe" href="modif_article.php?id=<?php echo $id; ?>">Modifier l'article</div></li>
        <?php } ?>


        <div class="clear"></div>

      <div class="discographie">
        <header>discographie</header>

       <?php

       		// Requêtes preparées
       		$sql_album = $pdo->prepare("SELECT * FROM album WHERE album.id_artiste= :id ORDER BY annee_sortie DESC");
       		$sql_titre = $pdo->prepare("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = :id_album ORDER BY piste ASC");
       		$sql_role = $pdo->prepare('SELECT * FROM a_un_role INNER JOIN personne ON personne.id_personne=a_un_role.id_personne INNER JOIN type_role ON type_role.id_type_role=a_un_role.id_type_role WHERE a_un_role.id_album = :id_album AND type_type_role = :role ORDER BY nom_type_role');
       		$sql_structure = $pdo->prepare('SELECT * FROM structure_role_album INNER JOIN structure_sonotk ON structure_role_album.id_structure = structure_sonotk.id_structure INNER JOIN type_role_structure_album ON type_role_structure_album.id_type_role_structure_album = structure_role_album.id_type_role_structure_album WHERE id_album=:id_album');
       		$sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');
       		$sql_favori_album = $pdo->prepare('SELECT * FROM favori_album WHERE id_album=:id_album AND id_utilisateur=:id_utilisateur LIMIT 1');
       		// Fin requêtes preparées








			$sql_album->execute(array(':id' => $id ));
		   	while($res_album = $sql_album->fetch(PDO::FETCH_OBJ)):

		   		$id_album = $res_album->id_album;
				$nom_album = stripslashes($res_album->titre);
				$annee = $res_album->annee_sortie;
				$droit = $res_album->gestion_droit;

				$sjaquette = $pdo->query("SELECT * FROM portfolio_sonotheque WHERE id_pj='".$res_album->id_jaquette."'");
			   	$rjaquette = $sjaquette->fetch(PDO::FETCH_OBJ);
			   	$image = $_MUSIC_ROOT.$rjaquette->url_pj;

			   	if($annee==0) $annee="";
		   	?>

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
							 <?php if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""){ ?>
							<?php
							$action = "add";
							$class = "like";

							$sql_favori_album->execute(array("id_album"=>$id_album, "id_utilisateur"=>$_SESSION['id_utilisateur']));
							if($sql_favori_album->fetch(PDO::FETCH_OBJ)){
								$action="remove";
								$class = "like on";
							}
							?>
							<i class="<?php print $class; ?>" data-type="album" data-id="<?php print $id_album; ?>" data-action="<?php print $action; ?>"></i>
							<?php } ?>
							<!-- FIN LIKE -->

							<i class="share" data-fancybox-type="iframe" href="share.php?id=<?php print $id_album; ?>&page=album"></i>

						</section>

					</div>

					<div class="col-xs-12 col-sm-9 col-md-8">

						<ul class="tracks" >

						<?php

				        $sql_titre->execute(array(':id_album'=>$id_album));


				        while($res_titre = $sql_titre->fetch(PDO::FETCH_OBJ)):

							$duree_chanson = $res_titre->duree;
							$nom_chanson = $res_titre->nom;
							$id_pj = $res_titre->id_pj;
							$path = $res_titre->url_pj;
							$nom_fichier = $res_titre->nom_pj;
							$id_chanson = $res_titre->id_chanson;
							$artiste = $res_titre->nom_artiste;
							$album = $res_titre->titre;
							$piste = $res_titre->piste;
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





		<!-- infos plus -->
	  <div class="clear"></div>
      <div class="infosplus">
      	<span class="plusmoinsinfos"><i class="plus"></i></span>
      	<div class="artisteAlbum">

            <div class="colMusicien">
            <?php

                $sql_role->execute(array(':id_album' => $id_album , ':role' => 'musicien' ));
                while($res_role = $sql_role->fetch(PDO::FETCH_OBJ)){
                    $nom = $res_role->prenom_personne.' '.$res_role->nom_personne;
                    $role = $res_role->nom_type_role;
                    echo "<strong>".$role." : </strong>".$nom.'<br>';
                }

            ?>
            </div>
            <div class="colTechnicien">
            <?php

                $sql_role->execute(array(':id_album' => $id_album , ':role' => 'technicien' ));
                while($res_role = $sql_role->fetch(PDO::FETCH_OBJ)){
                    $nom = $res_role->prenom_personne.' '.$res_role->nom_personne;
                    $role = $res_role->nom_type_role;
                    echo "<strong>".$role." : </strong>".$nom.'<br>';
                }

            ?>
            </div>
            <br>

            <br>
            <?php

               	$sql_structure->execute(array(':id_album' => $id_album ));
                while($res_structure = $sql_structure->fetch(PDO::FETCH_OBJ)){

                    $role = $res_structure->nom_type_role_structure_album;
                    $nom = $res_structure->nom_structure;
                    echo "<strong>".$role." : </strong>".$nom.'<br>';
                }

            ?>

        </div>
      </div>

	  <!-- fin infos plus -->




		<?php
	   endwhile; // endwhile album
	  ?>










  </div>
  <?php
  $type_commentaire = "artiste";
  require_once('commentaire.php');
  ?>
 <?php require_once('bottom.php'); ?>
 <script>if (location.hash) { location.href = location.hash; }</script>
<?php require_once('footer.php');
$pdo = null;
?>
