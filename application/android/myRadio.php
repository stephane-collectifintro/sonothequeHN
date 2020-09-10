<?php

require('../../cn.php');
	//$id = 2;
	$rows['radio'] ;
	$id = $_GET['id'];


	$sql = $pdo->query("SELECT id_radio 
		FROM favori_radio 
		WHERE id_utilisateur='".$id."'");

	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$id_radio['id_radio'] = $res;
	}

	foreach ($id_radio['id_radio'] as $i => $id_radio) {

		$sql2 = $pdo->query("SELECT id_radio, titre_radio, image_radio
			FROM radio 
			WHERE online_radio = 1  AND id_radio= ".$id_radio['id_radio']."");		

		while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){
					$rows['radio'][] = $res2;
		}

	}


	print json_encode($rows);





?>