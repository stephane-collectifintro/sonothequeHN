<?php 

 require('../cn.php');

 $sql = $pdo->query("SELECT id_album,titre, nom_artiste, url_pj
 	FROM album 
 	INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj 
 	INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE album.gestion_droit != 3 ORDER BY date_insertion DESC LIMIT 10");
	
	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$rows['album'] = $res;
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