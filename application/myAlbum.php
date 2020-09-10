<?php
	require('../cn.php');
	//$id = 2;
	$rows['album'] ;

	$id = $_POST['id'];

	$sql = $pdo->query("SELECT id_album 
		FROM favori_album 
		WHERE id_utilisateur='".$id."'");

	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$id_albums['id_album'] = $res;

	}

	foreach ($id_albums['id_album'] as $i => $id_album) {
		$sql2 = $pdo->query("SELECT titre, url_pj,nom_artiste,id_album
			FROM album 
			INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
			INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
			WHERE album.gestion_droit != 3 AND album.id_album = ".$id_album['id_album']."");	

		while($res2 = $sql2->fetch(PDO::FETCH_ASSOC)){

			$rows['album'][] = $res2;
		}

	}
	for($i =0; $i< count($rows['album']); $i++){
		$thumb = 'http://sonotheque-hn.com/musik_sonotk/'.$rows['album'][$i][url_pj];
		$thumb_100 = str_replace('.jpg', '_thumb_100.jpg', $rows['album'][$i][url_pj]);

		if (file_exists('../musik_sonotk/'.$thumb_100)) { 
			$rows['album'][$i]["url_pj"] = 'http://sonotheque-hn.com/musik_sonotk/'.$thumb_100;
		}else{
			$rows['album'][$i]["url_pj"] = $thumb;
		}
	}
print json_encode($rows);

?>


