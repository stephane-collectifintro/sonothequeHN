<?php
 require('../cn.php');
 $date = date('Y-m-d');
 
 $sql = $pdo->query('SELECT * 
 	FROM interview 
 	INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste 
 	WHERE date_debut_interview<="'.$date.'" AND date_fin_interview>="'.$date.'" LIMIT 1');

   	while($res = $sql->fetch(PDO::FETCH_ASSOC)){
   		$rows['artiste'] = $res;
   	};
   	print json_encode($rows);
?>