<?php

if(!isset($_GET['token'])) {
  exit();
} 
$token = $_GET['token'];
// Connexion à la base de données
require_once("cn.php");

// la requête
$q = $pdo->query('SELECT fichier FROM media_tokens WHERE token="'.$token.'"');


// Si le token correspond à un enregistré en base de données
if($q->rowCount() == 1) { 
  // On récupère les résultats de la requête
  $resultat = $q->fetch();
  $fichier = $resultat['fichier']; // Dans le cas où vos fichiers multimédia se trouvent dans media/
  $size = filesize($fichier);
  $time = date('r', filemtime($fichier));
  $extension = end(explode('.', $fichier));

  // Si le fichier existe bien et qu'il est lisible, on peut le renvoyer au navigateur
  if(file_exists($fichier) && is_readable($fichier)) {
    // On peut maintenant effacer le token qui est en base de données
    $pdo->exec("DELETE FROM media_tokens WHERE token='".$token."'");
    
    // Ce header permet d'indiquer au navigateur quel à type de fichier il doit associer celui qu'on lui renvoie
    
    
    header('Content-type: audio/'.$extension);
    header('Content-Length: '.$size);
    readfile($fichier);
    exit();
  }
}