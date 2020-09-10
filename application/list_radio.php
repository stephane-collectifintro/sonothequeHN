<?php

require('../cn.php');

$action = $_POST['action'];

$sql = $pdo->query("SELECT id_radio, titre_radio, image_radio
	FROM radio 
	WHERE online_radio = 1 ");		
	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
			$rows['radio'] = $res;
}
print json_encode($rows);



?>