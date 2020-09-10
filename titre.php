<?php require_once('header.php'); ?>
<?php $id=$_GET['id']; ?>

<?php require_once('class/getid3/getid3.php'); ?>

<?php require_once('detect_browser.php'); ?>

		

		<?php 	


		$sql_favori_titre = $pdo->prepare('SELECT * FROM favori_titre WHERE id_chanson=:id_chanson AND id_utilisateur=:id_utilisateur LIMIT 1');





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

		<div class="page-header">
		  <h1><?php print $nom_chanson; ?><br><small><?php print $artiste; ?> - <?php print $album; ?></small></h1>
		</div>
		<article class="playlist" id="<?php print $id; ?>" type="track">

			<ul class="tracks left" >

			


				<li class="track" id="<?php print $id_pj; ?>">
					<img src="<?php print $image; ?>" class="left" height="32" style="margin-right:7px">
					<i class="ico_play left send"></i>
					<div class="info_track left">
						<span class="titre send"><?php print $nom_chanson; ?></span>
						<span class="duree"><?php print $duree_chanson; ?><span class="loader"></span></span>
						<span class="artiste_album"><?php print $artiste; ?> - <?php print $album; ?></span>
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
				

			</ul>
			<div class="clearfix"></div>

		</article>



  
  
 <?php require_once('bottom.php'); ?> 
 <script>if (location.hash) { location.href = location.hash; }</script>
<?php require_once('footer.php'); 
$pdo = null;
?>