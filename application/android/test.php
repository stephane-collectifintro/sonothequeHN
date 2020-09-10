<?php

    require('../../cn.php');

	$search = $_GET['recherche'];
	//$search = 'tokyo';
	$search = mysql_real_escape_string($search);
	$search =  htmlspecialchars_decode($search);
	$search = strtolower($search); //On met tout en minuscule 

// Artistes
$sql = $pdo->query("SELECT nom_artiste, id_artiste,id_photo,url_pj
FROM artiste 
INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = artiste.id_photo
WHERE nom_artiste LIKE '%".$search."%'
ORDER BY nom_artiste ASC");		
while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$rows['artistes'] = $res;
		
 }

 for($i =0; $i< count($rows['artistes']); $i++){

	$image_artiste = 'http://sonotheque-hn.com/musik_sonotk/'.$rows['artistes'][$i][url_pj];
	$idArtiste = intval($rows['artistes'][$i][id_artiste]);
	
	if($rows['artistes'][$i][id_photo] != 0){ 
			$rows['artistes'][$i] += array( "img" => $image_artiste);
	}
	$sql4 = $pdo->query("SELECT * FROM media WHERE id_artiste=".$idArtiste);
	while($res4 = $sql4->fetch(PDO::FETCH_OBJ)){
		$photo = 'http://sonotheque-hn.com/'.$res4->path_media;
		$rows['artistes'][$i] += array( "img" => $photo);
	}
} 

// Nom Albums
// id_album,titre, nom_artiste, url_pj
$sql2 = $pdo->query("SELECT *
FROM album 
INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
WHERE   album.gestion_droit != 3  AND (titre LIKE '%".$search."%'OR artiste.nom_artiste LIKE '%".$search."%')
ORDER BY titre ASC");		
while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){
		$rows['album'] = $res2;
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
// Morceaux
$sql3 = $pdo->query("SELECT nom, titre, url_pj,chanson.id_album,chanson.id_chanson
FROM chanson 
INNER JOIN album ON album.id_album = chanson.id_album
INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
WHERE nom LIKE '%".$search."%' OR artiste.nom_artiste LIKE '%".$search."%'
ORDER BY titre ASC");		
 while($res3 = $sql3->fetchAll(PDO::FETCH_ASSOC)){
		$rows['morceaux'] = $res3;
 }

for($i =0; $i< count($rows['morceaux']); $i++){
		$thumb = 'http://sonotheque-hn.com/musik_sonotk/'.$rows['morceaux'][$i][url_pj];
		$thumb_100 = str_replace('.jpg', '_thumb_100.jpg', $rows['morceaux'][$i][url_pj]);

		if (file_exists('../musik_sonotk/'.$thumb_100)) { 
			$rows['morceaux'][$i]["url_pj"] = 'http://sonotheque-hn.com/musik_sonotk/'.$thumb_100;

		
		}else{
			$rows['morceaux'][$i]["url_pj"] = $thumb;
		}
}

print json_encode($rows);

?>