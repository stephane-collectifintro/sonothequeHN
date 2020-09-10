<?php

if(isset($_GET['id'])){

	$mail=$_GET['mail'];
	//
	$sql = new sql();
	$sql2 = new sql();
	//
	$champs = array('valide_utilisateur');
	$values = array('oui');
	$sql->update("utilisateur",$champs,$values,"id_utilisateur=".$_GET['id']);
	if($sql->execute()){

		$headers ='From: "La Sonothèque Haute Normandie"<ne_pas_repondre@sonotheque-hn.com>'."\n";
		$headers .='Reply-To: ne_pas_repondre@sonotheque-hn.com'."\n";
		$headers .='Content-Type: text/html; charset="utf-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message ='Bonjour,<br><br>Votre compte Pro a bien été validé sur le site http://www.sonotheque-hn.com.<br><br>Vous pouvez vous y connecter dès maintenant grâce à vos identifiants de connexion qui vous ont été fournis dans un précédent email<br><br>Cordialement,<br>L\'équipe de la sonothèque';

		if(mail($mail, 'Votre compte est validé sur le site de la Sonothèque Haute-Normandie', $message, $headers)){
			echo 'Merci de votre inscription, vous pouvez vous connecter dès maintenant';
		}

		echo "<script>window.location.href='liste_utilisateur.php';</script>";
	}
}
?>
<div id="liste">
	<div class="titre">COMPTE</div>
	<table>
    <!--<tr><td align="right" colspan="5"><a href="ajout_album.php"><input type="button" value="Ajouter une album" /></a></td></tr>-->
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="4"></td></tr>
	<?php

	$ligne = true;

	$sql = new sql();

	if($_POST['search']){
		$sql->select("utilisateur","nom_utilisateur LIKE '%".$_POST['search']."%'","*","ORDER BY nom_utilisateur");
	}else{
		$sql->select("utilisateur","","*","ORDER BY nom_utilisateur");
	}
	$sql->execute();
	while($res = $sql->result()){

		$id = $res['id_utilisateur'];
		$nom = stripslashes(utf8_encode($res['nom_utilisateur']));
		$prenom = stripslashes(utf8_encode($res['prenom_utilisateur']));
		$type = stripslashes(utf8_encode($res['id_type_utilisateur']));
		$valide = stripslashes(utf8_encode($res['valide_utilisateur']));
		$mail = stripslashes(utf8_encode($res['mail_utilisateur']));
		if($type=="1"){
			$type = "Classique";
		}
		if($type=="2"){
			$type = "Pro";
		}
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}

	?>
    <tr class="<?php echo $color; ?>"><td><a href="utilisateur-<?php echo $id; ?>.php"><?php echo $nom.' '.$prenom; ?></a></strong></td><td align="center"><?php if($valide=="non"){?><a href="liste_utilisateur.php?id=<?php echo $id; ?>&mail=<?php echo $mail; ?>"><input type="button" value="valider le compte"></a><?php } ?></td><td width="20" align="center"><a href="utilisateur-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td></tr>
    <?php
	}
	?>
    </table>

</div>
