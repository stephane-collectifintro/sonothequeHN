
<?php if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""): ?>

<header id="profile">

	<div class="row">
		
		<div class="col-sm-2">

			<?php 
			$sql = $pdo->query("SELECT * FROM utilisateur WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
			$res = $sql->fetch(PDO::FETCH_OBJ);
			//
			$nom = $res->nom_utilisateur;
			$prenom = $res->prenom_utilisateur;
			$image_profile = $res->photo_utilisateur;
			$fid = $res->fid_utilisateur;
			if(empty($image_profile) && !empty($fid)){
				$image_profile = "https://graph.facebook.com/".$fid."/picture?width=300";
			}
			if(!empty($image_profile) && !empty($fid)){
				$image_profile = $image_profile;
			}
			if(empty($image_profile) && empty($fid)){
				$image_profile = "img/default_profile.svg";
			}
			?>
			
			<figure class="img-circle">
				<div class="inner img-circle">
					<div id="header-profil-image" class="inner img-circle" style="background-image: url(<?php print $image_profile; ?>);">
					
					</div>
				</div>
			</figure>


			
		</div>

		<div class="col-sm-10">

			<div class="name_profile"><?php print $prenom." ".$nom; ?><small><a href="mon_compte.php" title="Accédez à votre compte">Mon compte</a></small></div>
			
			<div class="links_profile">

				<ul>
					<li><a href="mes_coups_de_coeur.php" title="Accédez à vos titres favoris" id="link_coups_coeur"><img src="img/coup_coeur.svg">Coups de coeur</a></li>
					<li><a href="mes_albums.php" title="Accédez à vos albums favoris" id="link_albums_fav"><img src="img/album.svg">Albums préférés</a></li>
					<li><a href="mes_playlists.php" title="Accédez à vos playlists" id="link_playlists"><img src="img/playlist.svg">Mes playlists</a></li>
					<?php 
					$sql = $pdo->query("SELECT * FROM radio WHERE online_radio!=0");
					if ($sql->fetch(PDO::FETCH_OBJ)): ?>
						<li><a href="mes_radios.php" title="Accédez à vos radios favorites" id="link_radios_fav"><img src="img/radio.svg">Mes radios</a></li>
					<?php endif ?>
				</ul>
				
			</div>	


		</div>

	</div>

</header>



<?php endif; ?>