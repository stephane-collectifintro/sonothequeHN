<?php require_once('header.php'); ?>

    <div id="center">
    
      



	<div id="search_result">



	<?php


	/* RECHERCHE CLASSIC */


	if(isset($_GET['search']) && !empty($_GET['search']) && strlen($_GET['search'])>=2 ):

		$action = $_GET['action'];
		$search = str_replace("+","",addslashes($_GET['search']));
		$search_array = explode(" ",$search);
		$nb_result = 0;
	?>
		

		<!-- SEARCH ARTISTE -->

		<?php if (isset($action) && ($action=="all" || $action=="artiste") ) : ?>
			
		
			<?php
			$query = array();
			foreach ($search_array as $value) {
				$query[]="artiste.nom_artiste LIKE '%".$value."%' ";
			}
			$query = implode(" AND ",$query);

			$sql = $pdo->query("SELECT * 
								FROM artiste 
								WHERE ".$query."
								ORDER BY artiste.nom_artiste ASC");	
			
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
			

			</ul>

			<?php endif; ?>


		<?php endif; ?>

		<!-- FIN SEARCH ARTISTE -->

        <!-- SEARCH TAGS -->

		<?php if (isset($action) && ($action=="all" || $action=="artiste") ) : ?>
			
		
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

		<?php if (isset($action) && ($action=="all" || $action=="album")) : ?>

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
								ORDER BY album.titre ASC");

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
			
			</ul>

			<?php endif; ?>

		<?php endif; ?>
		<!-- FIN SEARCH ALBUM -->

		

		<!-- SEARCH TITRE -->
		<?php if (isset($action) && ($action=="all" || $action=="titre")) : ?>

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
								ORDER BY chanson.nom ASC");	

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
			
			</ul>

			<?php endif; ?>


		<?php endif; ?>
		<!-- FIN SEARCH TITRE -->


		
		<?php  if ($total===0 ) print "Aucun résultat pour \"<i>".$search."</i>\""; ?>


	<?php endif; ?> <!-- FIN GET SEARCH -->

	<?php if ( (isset($_GET['search']) && empty($_GET['search'])) || (isset($_GET['search']) && strlen($_GET['search'])<2) ) print "Recherche vide, veuillez entrer 2 caractères minimum !";  ?>




	<?php 

	//
	
	
	if(isset($_GET['style']) || isset($_GET['ville']) || isset($_GET['date'])){




		$style = $_GET['style'];
		$ville = addslashes($_GET['ville']);
		$date = $_GET['date'];
		//
		$recherche = array();



	

		/* VILLE */

		if(!empty($ville)):

			$total = 0;

			$sql = $pdo->query("SELECT * 
								FROM artiste 
								WHERE artiste.ville='".$ville."' 
								ORDER BY nom_artiste ASC");

			$nb_result = $sql->rowCount();
			$total += $nb_result;

			$ville = "de ".$ville;
			$ville = str_replace("de Le ","du ", $ville);
			$ville = str_replace("de Les ","des ",$ville);

			if ($nb_result!==0):

				
			?>		
			<ul>
				<li class="header">Artistes <?php print $ville; ?></li>
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
			
			</ul>


			<?php else: ?> <!-- else nbresult!==0 -->

				<?php if ($total===0 ) print "<div class='alert alert-warning' role='alert'>Aucun artiste ".$ville." trouvé</div>"; ?>

			<?php endif; ?> <!-- end if nbresult!==0 -->

		<?php endif; ?><!-- end if empty ville -->










		<?php

		/* STYLE */

		if(!empty($style) || !empty($date)):

			$total = 0;

			if(!empty($style)){
				array_push($recherche,"album.id_type_style='".$style."'");
				$sql = $pdo->query("SELECT * 
									FROM type_style 
									WHERE id_type_style=".$style);
				$res=$sql->fetch(PDO::FETCH_OBJ);
				$style = " de ".$res->nom;


			}
			
			if(!empty($date)){
				array_push($recherche,"album.annee_sortie='".$date."'");
				$date = " de ".$date;
			}
		
			$recherche = implode(" AND ",$recherche);

			$sql = $pdo->query("SELECT * 
								FROM album 
								INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
								WHERE ".$recherche." ORDER BY album.titre ASC");

			$nb_result = $sql->rowCount();
			$total += $nb_result;
			if ($nb_result!==0):	
		?>		
			<ul>
				<li class="header">AlBUMS<?php print $style."".$date; ?> </li>
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
			
			</ul>

			<?php else: ?> <!-- else nbresult!==0 -->

				<?php if ($total===0 ) print "<div class='alert alert-warning' role='alert'>Aucun album".$style."".$date." trouvé</div>"; ?>

			<?php endif; ?> <!-- end if nbresult!==0 -->

		<?php endif; ?><!-- end if empty ville -->









		<?php 

	} /* end isset style ville date */

	?>


</div>










      <?php require_once('bottom.php') ?>
    </div>
  
<?php require_once('footer.php'); ?>