	<?php
	
if(!isset($_GET['token'])) {

exit();

}

$token = $_GET['token'];

// Connexion à la base de données
require('cn.php');

// Préparation de la requête

$q = $pdo->query('SELECT fichier FROM media_tokens WHERE token="'.$_GET['token'].'"');

// Exécution !


// Si le token correspond à un enregistré en base de données

if($q->rowCount() == 1) {

// On récupère les résultats de la requête

$resultat = $q->fetch();

$fichier = $resultat['fichier']; // Dans le cas où vos fichiers multimédia se trouvent dans media/
$size	= filesize($fichier);
$time	= date('r', filemtime($fichier));

$begin=0;
$end=$size;


// Si le fichier existe bien et qu'il est lisible, on peut lerenvoyer au navigateur

	if(file_exists($fichier) && is_readable($fichier)) {

		// On peut maintenant effacer le token qui est en base de données
		
		//$pdo->exec("DELETE FROM media_tokens WHERE token='".$_GET['token']."'");
		
		// Ce header permet d'indiquer au navigateur quel à type defichier il doit associer celui qu'on lui renvoie
		
		/*$shortlen = $size - 1;
		
		$fp = fopen($fichier, 'r');
		$etag = md5(serialize(fstat($fp)));
		fclose($fp);
		
		
		header("Pragma: public");
		header("Expires: 0");
		header('Content-Type:audio/mpeg');
		header('Cache-Control: public'); 
		header('Content-Length: '.$size);
		header("Content-Range: bytes $begin-$end/$size");
		header("Content-Disposition: inline; filename=$fichier");
		header("Content-Transfer-Encoding: binary");
		header('Etag: '.$etag);
		
		readfile($fichier);
		exit();*/
		
		function serve_file_resumable ($file, $contenttype = 'application/octet-stream') {

    // Avoid sending unexpected errors to the client - we should be serving a file,
    // we don't want to corrupt the data we send
    @error_reporting(0);

    // Make sure the files exists, otherwise we are wasting our time
    if (!file_exists($file)) {
      header("HTTP/1.1 404 Not Found");
      exit;
    }

    // Get the 'Range' header if one was sent
    if (isset($_SERVER['HTTP_RANGE'])) $range = $_SERVER['HTTP_RANGE']; // IIS/Some Apache versions
    else if ($apache = apache_request_headers()) { // Try Apache again
      $headers = array();
      foreach ($apache as $header => $val) $headers[strtolower($header)] = $val;
      if (isset($headers['range'])) $range = $headers['range'];
      else $range = FALSE; // We can't get the header/there isn't one set
    } else $range = FALSE; // We can't get the header/there isn't one set

    // Get the data range requested (if any)
    $filesize = filesize($file);
    if ($range) {
      $partial = true;
      list($param,$range) = explode('=',$range);
      if (strtolower(trim($param)) != 'bytes') { // Bad request - range unit is not 'bytes'
        header("HTTP/1.1 400 Invalid Request");
        exit;
      }
      $range = explode(',',$range);
      $range = explode('-',$range[0]); // We only deal with the first requested range
      if (count($range) != 2) { // Bad request - 'bytes' parameter is not valid
        header("HTTP/1.1 400 Invalid Request");
        exit;
      }
      if ($range[0] === '') { // First number missing, return last $range[1] bytes
        $end = $filesize - 1;
        $start = $end - intval($range[0]);
      } else if ($range[1] === '') { // Second number missing, return from byte $range[0] to end
        $start = intval($range[0]);
        $end = $filesize - 1;
      } else { // Both numbers present, return specific range
        $start = intval($range[0]);
        $end = intval($range[1]);
        if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) $partial = false; // Invalid range/whole file specified, return whole file
      }      
      $length = $end - $start + 1;
    } else $partial = false; // No range requested

    // Send standard headers
    header("Content-Type: $contenttype");
    header("Content-Length: $filesize");
    header('Content-Disposition: inline; filename="'.basename($file).'"');
    header('Accept-Ranges: bytes');

    // if requested, send extra headers and part of file...
    if ($partial) {
      header('HTTP/1.1 206 Partial Content'); 
      header("Content-Range: bytes $start-$end/$filesize"); 
      if (!$fp = fopen($file, 'r')) { // Error out if we can't read the file
        header("HTTP/1.1 500 Internal Server Error");
        exit;
      }
      if ($start) fseek($fp,$start);
      while ($length) { // Read in blocks of 8KB so we don't chew up memory on the server
        $read = ($length > 8192) ? 8192 : $length;
        $length -= $read;
        print(fread($fp,$read));
      }
      fclose($fp);
    } else readfile($file); // ...otherwise just send the whole file

    // Exit here to avoid accidentally sending extra content on the end of the file
    exit;

  }
  serve_file_resumable ($fichier, $contenttype = 'audio/mpeg');
  
	
	
	}

}

else {

header('Content-type: audio/mp3');
	

readfile('media/fail.mp3');


}

?>