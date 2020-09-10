
<!-- NEWS -->
<div id="news">
  <header>
    <h2>news</h2>
  </header>
  <div class="liste">
      <ul>
       <?php
			$sql = $pdo->query("SELECT * FROM actualite ORDER BY date_actualite DESC");
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				$id_actualite = $res->id_actualite;
				$actualite = stripslashes($res->titre_actualite);

		?>
      <li><a href="actualite-<?php echo $id_actualite; ?>.php" title="<?php echo $actualite; ?>"><?php echo $actualite; ?></a></li>
      <?php
			}
	  ?>
      </ul>

  </div>
  <!--<div class="base">> Voir toutes les actualités</div>-->
</div>

<!-- TOP INTERVIEW -->
<div id="topAl">
  <header>
    <h2>Dernières interviews<?php print $truc; ?></h2>
  </header>
  <div class="liste">
    <ul>
    	<?php
			$date = date('Y-m-d');

			$sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste ORDER BY date_debut_interview DESC LIMIT 10');
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				$id_artiste = $res->id_artiste;
				$nom_artiste = stripslashes($res->nom_artiste);
         $id_interview3 = $res->id_interview;

				$nom_url = clean(strtolower($nom_artiste));

		?>
		<li><a href="interview-<?php echo $id_interview3; ?>.php" title="L'interview de <?php echo $nom_artiste; ?>"><span class="bold"><?php echo $nom_artiste; ?></span></a></li>
		<?php } ?>
    </ul>
  </div>
</div>

<!-- TOP INTERVIEW -->
<div id="topAl">
  <header>
    <h2>Clips récents<?php print $truc; ?></h2>
  </header>
  <div class="liste">
    <ul>
    	<?php
			$date = date('Y-m-d');

			$sql = $pdo->query('SELECT * FROM top_semaine INNER JOIN album ON top_semaine.id_album = album.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE  date_debut_top_semaine<="'.$date.'" AND iframe_top_semaine!="" ORDER BY date_debut_top_semaine DESC LIMIT 10');
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
        $id_top = $res->id_top_semaine;
        $nom_artiste = $res->nom_artiste;
        $texte = new texte();
        //$nom_artiste = str_replace('-','_',strtolower($texte->clean($nom_artiste)));

		?>
		<li><a href="clip_album_semaine-<?php echo $id_top; ?>.php" title="<?php echo $nom_artiste; ?>"><span class="bold"><?php echo $nom_artiste; ?></span></a></li>
		<?php } ?>
    </ul>
  </div>
</div>
<div class="widget" style="margin-top: 5px;">
<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fsonothequenormandie&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=1768490863389543" width="340" height="130" style="border:none;overflow:hidden;width:100%" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
</div>