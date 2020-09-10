	<?php

    require('../cn.php');

	$id = $_POST['id'];
	
	//$id = '1172';
	
	if(!empty($_POST['id_chanson']) && isset($_POST['id_chanson'])){
		$idChanson = $_POST['id_chanson'];
	}

	$sql = $pdo->query("SELECT titre, url_pj,nom_artiste
	FROM album 
	INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
	INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = album.id_jaquette
	WHERE album.gestion_droit != 3 AND album.id_album = ".$id."");		
	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$rows['pochette'] = $res;
	}	

	// Nom Albums
	$sql2 = $pdo->query("SELECT *
		FROM album 
		INNER JOIN chanson ON chanson.id_album = album.id_album
		INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
		WHERE album.gestion_droit != 3  AND album.id_album = ".$id."");		
		while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){
				$rows['album'] = $res2;
	}
		
	if(!empty($_POST['id_chanson']) && isset($_POST['id_chanson'])){
		foreach ($rows['album'] as $key => $album) {
			if($album['id_chanson'] == $idChanson)  $rows['pos'] = array( "pos" => $key);
			
		}
	}else $rows['pos'] = array( "pos" => 'undefined');
	
	print json_encode($rows);
?>