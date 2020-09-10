<?php
	require_once('init.php');
	require_once('cn.php');
	if(isset($_POST['type']) && !empty($_POST['type'])){



		if($_POST['type']=='titre'){
			$sql = $pdo->exec("UPDATE portfolio_sonotheque SET counter_pj = counter_pj+1 WHERE id_pj=".$_POST['id']);
		}
		if($_POST['type']=='artiste'){



			
			if(isset($_SESSION['artiste'])){

				if(array_search($_POST['id'],$_SESSION['artiste'])===false){
					
					$sql = $pdo->exec("UPDATE artiste SET counter_artiste = counter_artiste+1 WHERE id_artiste=".$_POST['id']);
					array_push($_SESSION['artiste'],$_POST['id']);
				}
			}
			
		}
		if($_POST['type']=='album'){
			
			if(isset($_SESSION['album'])){
				if(array_search($_POST['id'],$_SESSION['album'])===false){
					$sql = $pdo->exec("UPDATE album SET counter_album = counter_album+1 WHERE id_album=".$_POST['id']);
					array_push($_SESSION['album'],$_POST['id']);
				}
			}
		
		}
	}
?>