<?php require_once("cn.php"); ?>

<!---------------------------------------------------->
<!----------------- DATES CONCERTS ------------------->
<!---------------------------------------------------->

<?php
$url = "https://fabrikasons.com/?feed=gigpress"; /* insérer ici l'adresse du flux RSS de votre choix */
$rss = simplexml_load_file($url);
?>
<div id="topConcert">
  <header>
    <h2>les concerts</h2>
  </header>
  <div class="liste">
    <ul>
    	<?php
				foreach ($rss->channel->item as $item){
					echo '<li><a target="_blank" href="https://fabrikasons.com/les-concerts/">'.$item->title.'</a></li>';
				}
			?>
		</ul>
	</div>
</div>
<!---------------------------------------------------->
<!----------------- TOP ARTISTES --------------------->
<!--------------------------------------------------
<?php
function clean($badstring){
	$pattern = Array("é", "è", "ê", "ç", "à", "â", "î", "ï", "ù", "ô","'");
	$rep_pat = Array("e", "e", "e", "c", "a", "a", "i", "i", "u", "o","-");
	$cleaned= str_replace($pattern, $rep_pat, $badstring);
	$file_bad = array("@-@", "@_@", "@[^A-Za-z0-9_ ]@", "@ +@");
	$file_good = array(" ", " ", "", " ");
	$cleaned= preg_replace($file_bad, $file_good, $cleaned);
	$cleaned= str_replace(" ", "_", trim($cleaned));
	return $cleaned;
}
?><div id="top">
  <header>
    <h2>top artistes </h2>
  </header>
  <div class="liste">
    <ul>
    	<?php

			//require("class/texte.class.php");
			$sql = $pdo->query("SELECT * FROM artiste ORDER BY counter_artiste DESC LIMIT 10");
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				$id_artiste = $res->id_artiste;
				$nom_artiste = stripslashes($res->nom_artiste);


				$nom_url = clean(strtolower($nom_artiste));

		?>
      <li><a href="artiste-<?php echo $id_artiste; ?>-<?php echo $nom_url; ?>.php" title="<?php echo $nom_artiste; ?>"><span class="bold"><?php echo $nom_artiste; ?></span></a></li>
      <?php
			}
	  ?>
    </ul>
  </div>
</div>
-->
<!-- TOP ALBUMS


<div id="topAl">
  <header>
    <h2>top albums <?php print $truc; ?></h2>
  </header>
  <div class="liste">
    <ul>
    	<?php
			$sql = $pdo->query("SELECT * FROM album INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj INNER JOIN artiste ON album.id_artiste = artiste.id_artiste ORDER BY counter_album DESC LIMIT 10");
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				//
				$id_artiste = $res->id_artiste;
				$nom_artiste = stripslashes($res->nom_artiste);

				$nom_url = clean(strtolower($nom_artiste));
				//
				$id_album = $res->id_album;
				$jaquette = $_MUSIC_ROOT.$res->url_pj;
				$jaquette_thumb = str_replace('.jpg', '_thumb.jpg', $jaquette);
				if (is_readable($jaquette_thumb)) {
					$jaquette = $jaquette_thumb;
				}
				$nom_album = stripslashes($res->titre);
				$annee_album = $res->annee_sortie;
				if($annee_album==0){
					$annee_album = "";
				}
		?>

      <li><a href="artiste-<?php echo $id_artiste; ?>-<?php echo $nom_url; ?>.php#<?php echo $id_album; ?>" title="<?php echo $nom_artiste; ?>">
      	<span class="img" style="background-image:url(<?php echo $jaquette; ?>); background-size:contain; height:50px; width:50px;"></span>
        <div class="info">
            <h2><?php echo $nom_album; ?></h2>
            <h3><?php echo $nom_artiste; ?></h3>
            <p><?php echo $annee_album; ?></p>
        </div>
        <div class="clear"></div>
        </a>
      </li>

      <?php } ?>
    </ul>
  </div>
</div>
-->




<!-- DERNIERS ALBUMS -->



<div id="derAl">
  <header>
    <h2>derniers albums </h2>
  </header>
  <div class="liste">
    <ul>
      <?php
			$sql = $pdo->query("SELECT * FROM album INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj INNER JOIN artiste ON album.id_artiste = artiste.id_artiste ORDER BY date_insertion DESC LIMIT 10");
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				//
				$id_artiste = $res->id_artiste;
				$nom_artiste = stripslashes($res->nom_artiste);
				$nom_url = clean(strtolower($nom_artiste));
				//
				$id_album = $res->id_album;
				$jaquette = $_MUSIC_ROOT.$res->url_pj;
				$nom_album = stripslashes($res->titre);
				$annee_album = $res->annee_sortie;
				if($annee_album==0){
					$annee_album = "";
				}
		?>

      <li>
      	<a href="artiste-<?php echo $id_artiste; ?>-<?php echo $nom_url; ?>.php#<?php echo $id_album; ?>" title="<?php echo $nom_artiste; ?>">
      	<span class="img" style="background-image:url(<?php echo $jaquette; ?>); background-size:contain; height:50px; width:50px;"></span>
        <div class="info">
            <h2><?php echo $nom_album; ?></h2>
            <h3><?php echo $nom_artiste; ?></h3>
            <p><?php echo $annee_album; ?></p>
        </div>
        <div class="clear"></div>
        </a>
      </li>

      <?php } ?>
    </ul>
  </div>
</div>
<div id="download">
<a href="https://itunes.apple.com/fr/app/sonotheque/id703327274?mt=8" target="_blank"> <img src="img/sonotheque-appstore.png" class="img-responsive" style="margin-top:10px;"></a>
<a href="https://play.google.com/store/apps/details?id=com.collectifintro.sono" target="_blank"><img src="img/sonotheque-android.png" class="img-responsive" style="margin-top:10px;"></a>
</div>

<div class="widget" style="margin-top:10px;"> <a href="proposer_creation_musicale.php" ><img src="img/creaMus.png" width="100%" /></a> </div>
<div class="widget" style="margin-bottom: 0;"><h2>Suivez-nous sur...</h2><a href="https://twitter.com/sonothequeN" target="_blank"><img src="img/suivreTwitter.png" height="32" style="margin:0 10px;" /></a><a href="https://www.youtube.com/user/sonothequehn" target="_blank"><img src="img/suivreYoutube.png" height="32" style="margin:0 10px;" /></a></div>
