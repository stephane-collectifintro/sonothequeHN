<?php 
$page_name = str_replace('.php','',basename($_SERVER['PHP_SELF']));
$id = $_GET['id'];
?>






<!--=======================================-->
<!--=============== ARTISTE ===============-->
<!--=======================================-->




<?php 

if($page_name=="artiste"){

	$sql = $pdo->query("SELECT * FROM artiste INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj=artiste.id_photo WHERE artiste.id_artiste=".$id);
	$res = $sql->fetch(PDO::FETCH_OBJ);
	//
	$nom_artiste = stripslashes($res->nom_artiste);
	$bio_artiste = addslashes(strip_tags($res->bio_artiste));
	$url_site = stripslashes($res->url_site_web);
	$url_site_2 = stripslashes($res->url_site_web_2);
	$image = $_ROOT.$_MUSIC_ROOT.$res->url_pj;
	
	if(!is_readable($image_artiste)){

		$sql = $pdo->query("SELECT * FROM media WHERE id_artiste=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		$image = $_ROOT.$res->path_media;

	}

?>
<meta property="og:title" id="og_title" content="<?php print $nom_artiste; ?> - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="article" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:image" id="og_image" content="<?php print $image; ?>" />
<meta property="og:description" id="og_description" content="<?php print $bio_artiste; ?>" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $nom_artiste; ?> - Sonothèque Normandie">
<meta name="twitter:description" content="<?php print $bio_artiste; ?>">
<meta name="twitter:image" content="<?php print $image; ?>">

<?php } ?>






<!--=====================================-->
<!--=============== ALBUM ===============-->
<!--=====================================-->





<?php

if($page_name=="album"){

	$s0 = $pdo->query("SELECT * 
    				   FROM album 
    				   INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
    				   WHERE album.id_album=".$id);

	$res0 = $s0->fetch(PDO::FETCH_OBJ);

	$id_album = $res0->id_album;
	$nom_album = stripslashes($res0->titre);
	$annee = $res0->annee_sortie;
	$droit = $res0->gestion_droit;
	$artiste = $res0->nom_artiste;
	$description = addslashes(strip_tags($res0->bio_artiste));

	$sjaquette = $pdo->query("SELECT * FROM portfolio_sonotheque WHERE id_pj='".$res0->id_jaquette."'");
   	$rjaquette = $sjaquette->fetch(PDO::FETCH_OBJ);
   	$image = $_ROOT.$_MUSIC_ROOT.$rjaquette->url_pj;
   	
   	if($annee==0) $annee="";



?>

<meta property="og:title" id="og_title" content="<?php print $nom_album; ?> (<?php print $artiste; ?>, <?php print $annee; ?>) - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="music.playlist" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:image" id="og_image" content="<?php print $image; ?>" />
<meta property="og:description" id="og_description" content="<?php print $description; ?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $nom_album; ?> (<?php print $artiste; ?>, <?php print $annee; ?>) - Sonothèque Normandie">
<meta name="twitter:description" content="<?php print $description; ?>">
<meta name="twitter:image" content="<?php print $image; ?>">


<?php } ?>







<!--===================================================-->
<!--=============== ALBUM DE LA SEMAINE ===============-->
<!--===================================================-->





<?php

if($page_name=="clip_album_semaine"){

	$date = date('Y-m-d');
   	$s0 = $pdo->query('SELECT * 
   	 				    FROM top_semaine 
   					    INNER JOIN album ON top_semaine.id_album = album.id_album 
   					    INNER JOIN artiste ON album.id_artiste = artiste.id_artiste 
   					    WHERE date_debut_top_semaine<="'.$date.'" AND date_fin_top_semaine>="'.$date.'" AND id_top_semaine="'.$id.'" LIMIT 1');

	$res0 = $s0->fetch(PDO::FETCH_OBJ);

	$id_album = $res0->id_album;
	$iframe = $res0->iframe_top_semaine;
	$nom_album = stripslashes($res0->titre);
	$annee = $res0->annee_sortie;
	$droit = $res0->gestion_droit;
	$artiste = $res0->nom_artiste;
	$description = addslashes(strip_tags($res0->bio_artiste));

	$sjaquette = $pdo->query("SELECT * FROM portfolio_sonotheque WHERE id_pj='".$res0->id_jaquette."'");
   	$rjaquette = $sjaquette->fetch(PDO::FETCH_OBJ);
   	$image = $_ROOT.$_MUSIC_ROOT.$rjaquette->url_pj;
   	
   	if($annee==0) $annee="";



?>

<meta property="og:title" id="og_title" content="<?php print $nom_album; ?> (<?php print $artiste; ?>, <?php print $annee; ?>) - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="music.playlist" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:image" id="og_image" content="<?php print $image; ?>" />
<meta property="og:description" id="og_description" content="<?php print $description; ?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $nom_album; ?> (<?php print $artiste; ?>, <?php print $annee; ?>) - Sonothèque Normandie">
<meta name="twitter:description" content="<?php print $description; ?>">
<meta name="twitter:image" content="<?php print $image; ?>">


<?php } ?>





<!--=====================================-->
<!--=============== TITRE ===============-->
<!--=====================================-->





<?php

if($page_name=="titre"){

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
	$description = addslashes(strip_tags($res->bio_artiste));
	

	$sql = $pdo->query("SELECT * 
    					FROM portfolio_sonotheque 
    					INNER JOIN album ON album.id_jaquette = portfolio_sonotheque.id_pj
    					WHERE album.id_album = ".$id_album);

 
    $res = $sql->fetch(PDO::FETCH_OBJ);
    $image = $_ROOT.$_MUSIC_ROOT.$res->url_pj;


?>

<meta property="og:title" id="og_title" content="<?php print $nom_chanson; ?> - <?php print $artiste; ?> - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="music.playlist" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:image" id="og_image" content="<?php print $image; ?>" />
<meta property="og:description" id="og_description" content="<?php print $description; ?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $nom_chanson; ?> - <?php print $artiste; ?> - Sonothèque Normandie">
<meta name="twitter:description" content="<?php print $description; ?>">
<meta name="twitter:image" content="<?php print $image; ?>">


<?php } ?>





<!--========================================-->
<!--=============== PLAYLIST ===============-->
<!--========================================-->





<?php

if($page_name=="ma_playlist"){

	$sql = $pdo->query("SELECT * FROM playlist INNER JOIN utilisateur ON playlist.id_utilisateur = utilisateur.id_utilisateur WHERE id_playlist=".$id." AND publique_playlist=1");
	$res = $sql->fetch(PDO::FETCH_OBJ);
	//
	if ($res){

		$titre = $res->nom_playlist;
		$image = "img/default_jaquette.png";
		$username = $res->prenom_utilisateur." ".$res->nom_utilisateur; 

		$sql2 = $pdo->prepare("SELECT url_pj 
			  		 		   FROM playlist_titre 
			     			   INNER JOIN chanson ON playlist_titre.id_chanson = chanson.id_chanson 
						  	   INNER JOIN album ON chanson.id_album = album.id_album
						  	   INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj
						  	   WHERE id_playlist=:id_playlist GROUP BY url_pj ORDER BY ordre_playlist_titre ASC");


?>

<meta property="og:title" id="og_title" content="<?php print $titre; ?> par <?php print $username; ?> - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="music.playlist" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:description" id="og_description" content="<?php print $description; ?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $titre; ?> - Sonothèque Normandie">
<meta name="twitter:description" content="...">


<?php 
$sql2->execute(array(":id_playlist"=>$id));
while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
	$image = $_ROOT.$_MUSIC_ROOT.$res2->url_pj;	
?>
	<meta property="og:image" id="og_image" content="<?php print $image; ?>" />
	<meta name="twitter:image" content="<?php print $image; ?>">
<?php
}
?>


<?php } ?>

<?php } ?>





<!--=====================================-->
<!--=============== RADIO ===============-->
<!--=====================================-->




<?php

if($page_name=="radio" && isset($id) ){

	$sql = $pdo->query("SELECT * FROM radio WHERE id_radio=".$id);
	$res = $sql->fetch(PDO::FETCH_OBJ);
	
	$titre = $res->titre_radio;
	$description = strip_tags($res->descriptif_radio);
	$image = $_ROOT.$res->image_radio;


?>

<meta property="og:title" id="og_title" content="<?php print $titre; ?> - Sonothèque Normandie" />
<meta property="og:type" id="og_type" content="music.playlist" />
<meta property="og:url" id="og_url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:description" id="og_description" content="<?php print $description; ?>" />
<meta property="og:image" id="og_image" content="<?php print $image; ?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php print 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:title" content="<?php print $titre; ?> - Sonothèque Normandie">
<meta name="twitter:description" content="<?php print $description; ?>">
<meta name="twitter:image" content="<?php print $image; ?>">


<?php } ?>






