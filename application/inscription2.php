<?php

require("../cn.php");
$rows['rep'];
//
//
$mail = $_POST["mail"];
$mdp = md5($_POST["mdp"]);
//$mail = "toto@yahoo.fr";
//$mdp = "titi";
//

if (!empty($mail) && isset($mail)){
$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='toto@yahoo.fr'");

if($sql->rowCount()>0){
			$rows['rep'] = array( 'success' => 'existe');
			print json_encode($rows);

}else{
if($sql2 = $pdo->exec("INSERT INTO utilisateur SET id_type_utilisateur='0', structure_utilisateur=' ', nom_utilisateur=' ', prenom_utilisateur=' ', mail_utilisateur='".$mail."', tel_utilisateur=' ', adresse_utilisateur=' ', cp_utilisateur=' ', ville_utilisateur=' ', password_utilisateur='".$mdp."', valide_utilisateur=' '")){
			
			
			$rows['rep'] = array( 'success' => 'done');
			print json_encode($rows);
	}else{
		$rows['rep'] = array( 'success' => 'fail');
		print json_encode($rows);
	}
}
}else{
	$rows['rep'] = array( 'success' => 'email');
	print json_encode($rows);
}


?>
