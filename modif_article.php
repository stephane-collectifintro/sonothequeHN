<?php
require_once('cn.php');
$id_artiste = $_GET['id'];
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Modifier un article</title>
</head>

<body style="width:600px; height:480px; margin:0; padding:0; text-align:right; font-family:Arial, Helvetica, sans-serif;">
<strong>PARTAGEZ VOTRE SAVOIR !</strong><br><br>

<form action="<?php echo $PHP_SELF; ?>" method="post">
<input type="text" name="mail" placeholder="Votre email" style="padding:5px; width:580px;" value="<?php echo $_POST['mail']; ?>" /><br><br>
<textarea name="texte" style="width:580px; height:250px; padding:5px;"  placeholder="Votre article"><?php echo $_POST['texte']; ?></textarea>
<br>
<input type="submit" style="text-align:right;"/>
</form>
<?php

if(isset($_POST['texte']) && isset($_POST['mail'])){
	$texte = utf8_decode($_POST['texte']);
	$mail = $_POST['mail'];
	if(filter_var($mail, FILTER_VALIDATE_EMAIL)){  
    //L'email est bonne  

		if($pdo->exec('INSERT INTO complement_artiste (`id_artiste`,`texte_complement_artiste`,`mail_complement_artiste`) VALUES ("'.$id_artiste.'","'.$texte.'","'.$mail.'")')){
			
			$headers ='From: ne_pas_repondre@sonotheque-hn.com<ne_pas_repondre@sonotheque-hn.com>'."\n"; 
			$headers .='Content-Type: text/html; charset="utf-8"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			
			$message ="Bonjour,<br><br>un complément a été apporté à la fiche d'un artiste<br><br>Vous pouvez retrouver ce dernier dans l'administration dans la section \"Complément Artiste\"<br><br>Merci"; 
			
			if(mail('contact@sonotheque-hn.com', 'Complément de fiche artiste - (ne pas répondre)', $message, $headers)){ 
			  echo "<script>parent.$.fancybox.close();</script>"; 
			}else{ 
			  echo "<script>alert('Problème lors de l'envoi')</script>"; 
			} 	
		}
	}else{
		echo "<script>alert('Adresse mail invalide')</script>";	
	}
}
?>
</body>
</html>