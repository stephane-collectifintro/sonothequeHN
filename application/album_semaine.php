<?php

    require('../cn.php');
    $date = date('Y-m-d');

	// ALBUM SEMAINE
   $sql = $pdo->query('SELECT titre, url_pj, album.id_album
   	FROM top_semaine 
   	INNER JOIN album ON top_semaine.id_album = album.id_album 
   	INNER JOIN artiste ON album.id_artiste = artiste.id_artiste 
   	INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj  
   	WHERE date_debut_top_semaine<="'.$date.'" AND date_fin_top_semaine>="'.$date.'" AND iframe_top_semaine="" LIMIT 1');
    $res = $sql->fetch(PDO::FETCH_ASSOC);
    $rows['pochette'] = $res;
/*
    // Nom Albums
	$sql2 = $pdo->query("SELECT album.id_album,titre,url_pj,duree
		FROM album 
		INNER JOIN chanson ON chanson.id_album = album.id_album
		INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
		WHERE album.id_album = ".$rows['pochette'][id_album]."");		
		while($res2 = $sql2->fetchAll(PDO::FETCH_ASSOC)){
			$rows['album'] = $res2;
		}*/

	print json_encode($rows);
?>