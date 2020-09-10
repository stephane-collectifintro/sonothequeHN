<?php

    require('../cn.php');
    $date = date('Y-m-d');


$sql = $pdo->query('SELECT plateforme_top_semaine, id_iframe,iframe_top_semaine,url_iframe_top_semaine
	FROM top_semaine 
	INNER JOIN album ON top_semaine.id_album = album.id_album 
	INNER JOIN artiste ON album.id_artiste = artiste.id_artiste 
	WHERE date_debut_top_semaine<="'.$date.'" AND date_fin_top_semaine>="'.$date.'" AND iframe_top_semaine!="" LIMIT 1');



$res = $sql->fetch(PDO::FETCH_ASSOC);
 	

 $id_iframe = $res['id_iframe'];  
$plateforme = $res['plateforme_top_semaine'];

if($plateforme=='youtube'){
   
   if(file_exists("http://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg")){ 
		$image = "http://img.youtube.com/vi/".$id_iframe."/maxresdefault.jpg"; 
	}else{ 
		$image = "http://img.youtube.com/vi/".$id_iframe."/0.jpg"; 
	}
	$url = "https://www.youtube.com/embed/".$id_iframe;
}

if($plateforme=='dailymotion'){

   if(file_exists("http://www.dailymotion.com/thumbnail/video/".$id_iframe)){ 
		$image = "http://www.dailymotion.com/thumbnail/video/".$id_iframe; 
	}else{ 
		$image = "http://www.dailymotion.com/thumbnail/video/".$id_iframe; 
	}
	$url = 'http://www.dailymotion.com/embed/video/'.$id_iframe; 
}
if($plateforme=='vimeo'){
	$thumb = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$id_iframe.'.php')); 
	$image = $thumb[0]['thumbnail_large'];
	$url = 'https://player.vimeo.com/video/'.$id_iframe;
}

  $rows['artiste'] = array( "img" => $image);
  $rows['artiste'] = array( "url" => $url);
  $rows['artiste'] += $res;
  
   


	print json_encode($rows);
?>
