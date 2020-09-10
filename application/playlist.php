<?php

	require('../cn.php');
	//$id = '98';
	$id = $_POST['id'];
    $sql = $pdo->query("SELECT nom,duree,url_pj,nom_artiste,id_playlist_titre as 'id_chanson'
		FROM `playlist_titre` 
		INNER JOIN chanson ON chanson.id_chanson=playlist_titre.id_chanson
		INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
		INNER JOIN album ON chanson.id_album = album.id_album
		INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
		WHERE id_playlist=".$id."
		ORDER BY ordre_playlist_titre ASC");

	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$rows['album'] = $res;

	}	
	$rows['pochette'][0] = array( "img" => 'img/default_jaquette.png');
	$rows['pos'] = array( "pos" => 'undefined');
	print json_encode($rows);

?>