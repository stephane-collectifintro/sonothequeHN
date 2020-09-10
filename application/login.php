<?php

require('../cn.php');
$login = $_POST['login'];
$password = $_POST['mdp'];
$rows;

//$login = "stephane@collectif-intro.com";
//$password = "t03288HN";
	$sql = $pdo->query("SELECT *
	FROM utilisateur
	WHERE mail_utilisateur='".$login."' AND password_utilisateur='".md5($password)."' LIMIT 1");		
		
	while($res = $sql->fetchAll(PDO::FETCH_ASSOC)){
		if(empty($res)){
			$rows['login'] = array( "succes" => 'false');	
		}else{
			$rows['login'] = array( "succes" => 'true');
			$rows['user'] = array( "id" => $res[0][id_utilisateur]);
			$rows['user_nom'] = array( "nom" => $res[0][nom_utilisateur]);
			$rows['user_prenom'] = array( "prenom" => $res[0][prenom_utilisateur]);
		}
	//$rows['login'] = array( "succes" => 'true');
	}


	
print json_encode($rows,JSON_UNESCAPED_UNICODE);



?>