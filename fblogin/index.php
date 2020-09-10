<?php
/*	FACEBOOK LOGIN + LOGOUT - PHP SDK V4.0 - BOOTSTRAP THEME
 *	file 			- index.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://packetcode.com/apps/fblogin-basic/
 *	Date 			- 27th Sept 2014
 *	license			- GNU General Public License version 2 or later
*/

/* INCLUSION OF LIBRARY FILEs*/
	require_once('../cn.php');
	require_once( 'facebookConnect.class.php');
	
	//1.Stat Session
	 session_start();

	 if(isset($_GET['origin'])){
	 	$origin = $_GET['origin'];
	 }else{
	 	$origin = "https://www.sonotheque-normandie.com";
	 }
	

	
	
	//2.Use app id,secret and redirect url 
	$app_id = '1664596733782772';
	$app_secret = 'a11999f5c1be4e1ff1470fcbdec8f01d';
	$redirect_url='https://www.sonotheque-normandie.com/fblogin/';

	//check if users wants to logout
	 /*if(isset($_REQUEST['logout'])){
	 	unset($_SESSION['fb_token']);
	 	header("location:".$redirect_url);
	 }
*/
	$connect = new FacebookConnect($app_id,$app_secret);

	$user = $connect->connect($redirect_url);


	if(is_string($user)){

		header("location:".$user);

	}else{

		  	  $fid = $user->getId();
			 $name = $user->getName();
		$firstname = $user->getFirstName();
		 $lastname = $user->getLastName();
			$email = $user->getEmail();
		 $location = explode(',',$user->getLocation()->getProperty('name'));
		 	 $city = $location[0];
		 	$image = 'https://graph.facebook.com/'.$id.'/picture?width=300';
		//

		//Check if Facebook id exists
		$sql = $pdo->query("SELECT * FROM `utilisateur` WHERE `fid_utilisateur` = ".$fid);
		
		if($res = $sql->fetch(PDO::FETCH_OBJ)){
		
			//if facebook id found, update account and put data in session
			$pdo->exec("UPDATE utilisateur SET nom_utilisateur='".$lastname."', prenom_utilisateur='".$firstname."', mail_utilisateur='".$email."', ville_utilisateur='".$city."' WHERE fid_utilisateur=".$fid);

			$_SESSION['id_utilisateur'] = $res->id_utilisateur;
			$_SESSION['nom_utilisateur'] = $lastname;
			$_SESSION['prenom_utilisateur'] = $firstname;

			header("location:".$origin);


		}else{

			//if no Facebook id found, check if email exists
			$sql_email = $pdo->query("SELECT * FROM utilisateur WHERE mail_utilisateur='".$email."'");

			if($res_mail = $sql_email->fetch(PDO::FETCH_OBJ)){

				//if email found, update account and put data in session
				$pdo->exec("UPDATE utilisateur SET nom_utilisateur='".$lastname."', prenom_utilisateur='".$firstname."', fid_utilisateur=".$fid.", ville_utilisateur='".$city."' WHERE mail_utilisateur='".$email."'");

				$_SESSION['id_utilisateur'] = $res_mail->id_utilisateur;
				$_SESSION['nom_utilisateur'] = $lastname;
				$_SESSION['prenom_utilisateur'] = $firstname;

				header("location:".$origin);

		
			}else{

				//if no email found, check if account 
				include("form_merge_account.php");

			}

		}
		

	}	



?>