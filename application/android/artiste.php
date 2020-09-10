<?php

    require('../../cn.php');

	$search = $_GET['id'];
	//$search = '210';
	//Bio
		$sql = $pdo->query("SELECT nom_artiste, bio_artiste, id_photo, ville, url_site_web,url_pj
		FROM artiste 
		INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = artiste.id_photo
		WHERE artiste.id_artiste = ".$search."
		ORDER BY artiste.id_artiste ASC");		
		while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
			$rows['artiste'] = $res;
			$image_artiste = 'http://sonotheque-hn.com/musik_sonotk/'.$rows['artiste'][0][url_pj];
			if($rows['artiste'][0][id_photo] != 0){ 
				$rows['artiste'][0] += array( "img" => $image_artiste);
			
			}
			
			$sql2 = $pdo->query("SELECT path_media FROM media WHERE id_artiste = ".$search);
			while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
					$photo = 'http://sonotheque-hn.com/'.$res2->path_media;
					$rows['artiste'][0] += array( "img" => $photo);
			}

		}

		// Albums
		$sql3 = $pdo->query("SELECT id_album,titre, url_pj
		FROM album 
		INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
		INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
		WHERE album.id_artiste = ".$search."
		ORDER BY titre ASC");		
		while($res3 = $sql3->fetchAll(PDO::FETCH_ASSOC)){
				$rows['album'] = $res3;
		}
		
		print json_encode($rows);
?>