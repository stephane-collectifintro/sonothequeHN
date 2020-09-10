<?php require_once "Mail.class.php";
 
// Créer un nouvel email
$mail = new Mail('postmaster@bdelespierre.fr', 'benjamin.delespierre@gmail.com', "test");
 
// Ajouter une partie textuelle
// qui ne sera affichée que si
// le client mail du destinataire
// ne supporte pas le mime
$mail->addMessagePart('Une chaine de caractères classique');
 
// Ajouter une partie en HTML
$mail->addMessagePart('<strong>Du HTML</strong> bien brutal', 'text/html');
 
// Ajouter une pièce-jointe
$mail->addAttachment('file.jpg', 'image/jpeg');
 
// Définir une deuxième destination
$mail->addDestination('foobar@yopmail.com');
 
// Visualiser le contenu de l'email
header('Content-Type: text/plain; encoding=utf-8');
echo $mail;
echo "\n\n--\n\n";
 
// Envoyer l'email et afficher le résultat
var_dump($mail->send());
?>