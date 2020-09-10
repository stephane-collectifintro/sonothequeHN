<?php 

	require('../../cn.php'); 
	require('../../class/sql.class.php');

    $sql = new sql();

    $id = $_POST['id'];
    $pct = $_POST['pct'];

    $sql->setQuery('UPDATE media SET y_align_media="'.$pct.'" WHERE id_media='.$id);
    //print $sql->getQuery();
    $sql->execute();

    
?>