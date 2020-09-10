
<?php

require('../cn.php');

	//$id = 684;
	$rows['titre'] ;
	$id = $_POST['id'];


	$sql = $pdo->query("SELECT id_chanson 
			FROM favori_titre 
			WHERE id_utilisateur='".$id."'");

	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$id_chansons['id_chanson'] = $res;
	}
	
	foreach ($id_chansons['id_chanson'] as $i => $id_chanson) {
		$sql2 = $pdo->query("SELECT nom, titre, url_pj,chanson.id_album, chanson.id_chanson
			FROM chanson 
			INNER JOIN album ON album.id_album = chanson.id_album
			INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
			INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
			WHERE id_chanson = ".$id_chanson['id_chanson']."");		
		while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){

			$rows['titre'][$i] = $res2;
			
		}

		
	}


		foreach ($rows['titre'] as $i => $titre) {


				
				$thumb = 'http://sonotheque-hn.com/musik_sonotk/'.$titre[0][url_pj];
				$thumb_100 = str_replace('.jpg', '_thumb_100.jpg', $titre[0][url_pj]);
			
				
				if (file_exists('../musik_sonotk/'.$thumb_100)) { 
					$rows['titre'][$i][0][url_pj] = 'http://sonotheque-hn.com/musik_sonotk/'.$thumb_100;
				}else{
					$rows['titre'][$i][0][url_pj] = $thumb;
				}



			
				

			}



/*

	for($i =0; $i< count($rows['titre']); $i++){
		print_r($rows['titre'][$i]);
		

		
	}*/


	print json_encode($rows, JSON_UNESCAPED_UNICODE);

?>