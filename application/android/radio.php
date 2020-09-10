<?php

require('../../cn.php');
$id = $_GET['id'];
//$id= 3;

$sql = $pdo->query("SELECT nom,duree,url_pj
	FROM `radio_titre` 
	INNER JOIN chanson ON chanson.id_chanson=radio_titre.id_chanson
	INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
	INNER JOIN album ON chanson.id_album = album.id_album
	INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
	WHERE id_radio=".$id." ORDER BY ordre_radio_titre ASC");	
	
	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
			$rows['album'] = $res;
	}


$sql2 = $pdo->query("SELECT image_radio, titre_radio
	FROM radio 
	WHERE id_radio=".$id." AND online_radio = 1 ");		
	while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){
			$rows['pochette'] = $res2;
}

if(!empty($_POST['id_chanson']) && isset($_POST['id_chanson'])){
		foreach ($rows['album'] as $key => $album) {
			if($album['id_chanson'] == $idChanson)  $rows['pos'] = array( "pos" => $key);
			
		}
	}else $rows['pos'] = array( "pos" => 'undefined');

print json_encode($rows);



?>