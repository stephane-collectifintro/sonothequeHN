<?php

	require('../cn.php');
	$id = $_POST['id'];
	//$id = '2';	
	$sql = $pdo->query("SELECT * 
		FROM playlist 
		WHERE id_utilisateur='".$id."' 
		ORDER BY nom_playlist ASC");

	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$rows['playlist'] = $res;

	}	
	foreach ($rows['playlist'] as $i => $id) {
		$rows['playlist'][$i] += array( "img" => 'img/default_jaquette.png');
	
	}
	
	 print json_encode($rows);

?>