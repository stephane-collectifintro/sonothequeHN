
<?php

require("cn.php");
require("class/texte.class.php");
//

if(isset($_POST['search']) ):

	$search = addslashes($_POST['search']);
	$search_array = explode(" ",$search);
	$nb_result = 0;
?>

	<!-- SEARCH ARTISTE -->
	<?php
	$query = array();
	foreach ($search_array as $value) {
		$query[]="artiste.nom_artiste LIKE '%".$value."%'";
	}
	$query = implode(" AND ",$query);

	$sql = $pdo->query("SELECT * 
						FROM artiste 
						WHERE ".$query."
						ORDER BY artiste.nom_artiste ASC LIMIT 5");	
	
	$nb_result = $sql->rowCount();
	$total += $nb_result;
	if ($nb_result!==0):

	?>	

	<ul>
		<li class="header">Artistes</li>
	<?php	
		
	while($res=$sql->fetch(PDO::FETCH_OBJ)):
		
		$id = $res->id_artiste;
		$nom = stripslashes($res->nom_artiste);
		$texte = new texte();
		$nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
		$url=$_MUSIC_ROOT.$res->url_pj;
			
	?>

	<li><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a></li>
	
	<?php endwhile; ?>

	<li class="footer"><a href="recherche.php?search=<?php print $search; ?>&action=artiste" title="Acceder à la liste complète des artistes correspondant à la recherche">Voir tous les artistes</a></li>
	
	</ul>

	<?php endif; ?>

	<!-- FIN SEARCH ARTISTE -->
    <!-- SEARCH TAGS -->

		<?php if (isset($_POST['search']) ) : ?>
			
		
			<?php
			$query = array();
			foreach ($search_array as $value) {
				$query[]="tag_name LIKE '%".$value."%' ";
			}
			$query = implode(" AND ",$query);

			$sql = $pdo->query("SELECT tag_id 
								FROM tags 
								WHERE ".$query."
								ORDER BY tag_name ASC");	
			
			$nb_result = $sql->rowCount();
			$total += $nb_result;
			if ($nb_result!==0):

			?>	

			<ul>
				<li class="header">Tags</li>
			<?php	
				
			while($res=$sql->fetch(PDO::FETCH_OBJ)):
				
				$id_tag = $res->tag_id;
                
				$sql2 = $pdo->query("SELECT id_item 
								     FROM item_tag 
								     WHERE id_tag =".$id_tag);
                
                while($res2=$sql2->fetch(PDO::FETCH_OBJ)):
                    $id_tag_artiste = $res2->id_item;
                    $sql3 = $pdo->query("SELECT * 
								        FROM artiste 
								        WHERE id_artiste=".$id_tag_artiste); 
                    $res3 = $sql3->fetch(PDO::FETCH_OBJ);
                    $id = $res3->id_artiste;
                    $nom = stripslashes($res3->nom_artiste);
                    $texte = new texte();
                    $nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
            ?>
                    
                
                <li><a><?php print( $sql3->fetch(PDO::FETCH_OBJ)->nom_artiste); ?></a></li>
                <li><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a>
                <?php endwhile; ?>
					

			
			
			<?php endwhile; ?>
			

			</ul>

			<?php endif; ?>


		<?php endif; ?>

		<!-- FIN SEARCH TAGS -->

	<!-- SEARCH ALBUM -->

	<?php
	
	$query = array();
	foreach ($search_array as $value) {
		$query[]="album.titre LIKE '%".$value."%' ";
	}
	$query = implode(" AND ",$query);

	$sql = $pdo->query("SELECT * 
						FROM album 
						INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
						WHERE ".$query."
						ORDER BY album.titre ASC LIMIT 5");

	$nb_result = $sql->rowCount();
	$total += $nb_result;
	if ($nb_result!==0):	
	?>		
	<ul>
		<li class="header">Albums</li>
	<?php	
			
	while($res=$sql->fetch(PDO::FETCH_OBJ)):
		
		$id = $res->id_artiste;
		$nom = stripslashes($res->nom_artiste);
		$texte = new texte();
		$nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
		$url=$_MUSIC_ROOT.$res->url_pj;
		$id_album = $res->id_album;
		$nom_album = stripslashes($res->titre);
			
	?>

	<li><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php#<?php echo $id_album; ?>" title="<?php echo $nom_album; ?>"><?php echo $nom_album; ?></a> <span>par <a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a></span></li>
	
	<?php endwhile; ?>

	<li class="footer"><a href="recherche.php?search=<?php print $search; ?>&action=album" title="Acceder à la liste complète des albums correspondant à la recherche">Voir tous les albums</a></li>

	</ul>

	<?php endif; ?>

	<!-- FIN SEARCH ALBUM -->

	

	<!-- SEARCH TITRE -->
	<?php

	$query = array();
	foreach ($search_array as $value) {
		$query[]="chanson.nom LIKE '%".$value."%' ";
	}
	$query = implode(" AND ",$query);

	$sql = $pdo->query("SELECT * 
						FROM chanson 
						INNER JOIN album ON chanson.id_album = album.id_album
						INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
						WHERE  ".$query." 
						ORDER BY chanson.nom ASC LIMIT 5 ");	

	$nb_result = $sql->rowCount();
	$total += $nb_result;
	if ($nb_result!==0):	
	?>		
	<ul>
		<li class="header">Titres</li>
	<?php	
			
	while($res=$sql->fetch(PDO::FETCH_OBJ)):
		
		$id = $res->id_artiste;
		$nom = stripslashes($res->nom_artiste);
		$texte = new texte();
		$nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
		$url=$_MUSIC_ROOT.$res->url_pj;
		$id_album = $res->id_album;
		$nom_album = stripslashes($res->titre);
		$id_chanson = $res->id_chanson;
		$nom_chanson = stripslashes($res->nom);
			
	?>

	<li><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php#<?php echo $id_album; ?>" title="<?php echo $nom_album; ?>"><?php echo $nom_chanson; ?></a> <span>par <a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a></span></li>
	
	<?php endwhile; ?>

	<li class="footer"><a href="recherche.php?search=<?php print $search; ?>&action=titre" title="Acceder à la liste complète des titres correspondant à la recherche">Voir tous les titres</a></li>

	</ul>

	<?php endif; ?>

	<!-- FIN SEARCH TITRE -->


	
	<?php  if ($total===0) print "Aucun résultat pour \"<i>".$search."</i>\""; ?>


<?php endif; ?>