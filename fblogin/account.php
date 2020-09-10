<?php
session_start();
foreach ($_POST as $key => $value) {
	$$key = $value;
}

require_once('../cn.php');





if (isset($action) && $action=="merge") {
	
	if (isset($login) && !empty($login) && isset($password) && !empty($password) ) {
		
		$sql = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$login."' AND password_utilisateur='".md5($password)."' LIMIT 1");
		if($res = $sql->fetch(PDO::FETCH_OBJ)){

			$pdo->exec("UPDATE utilisateur SET nom_utilisateur='".$nom."', prenom_utilisateur='".$prenom."', ville_utilisateur='".$city."', mail_utilisateur='".$mail."', fid_utilisateur=".$fid." WHERE mail_utilisateur='".$login."'");

			$_SESSION['id_utilisateur'] = $res->id_utilisateur;
			$_SESSION['nom_utilisateur'] = $nom;
			$_SESSION['prenom_utilisateur'] = $prenom;
			
			print "true";

			
		}else{
			print "false";
		}
		
	} else {
		print "false";
	}

	
} 







if (isset($_POST['action']) && $_POST['action']=="add") {
	
		
		if($pdo->exec("INSERT INTO utilisateur SET nom_utilisateur='".$nom."', prenom_utilisateur='".$prenom."', ville_utilisateur='".$city."', mail_utilisateur='".$mail."', fid_utilisateur=".$fid)){


			$nextID = $pdo->lastInsertId();
			$_SESSION['id_utilisateur'] = $nextID;
			$_SESSION['nom_utilisateur'] = $nom;
			$_SESSION['prenom_utilisateur'] = $prenom;
			
			print "true";

		}else{

			print "false";

		}
	

	
} 

?>