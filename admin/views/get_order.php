<?php 

	require('../../cn.php'); 
	require('../../class/sql.class.php');

    $sql = new sql();

    foreach($_POST['track'] as $position => $id_chanson):

	    $sql->setQuery('UPDATE radio_titre SET ordre_radio_titre='.$position.' WHERE id_chanson='.$id_chanson.' AND id_radio='.$_POST['id_radio']);
	    //print $sql->getQuery();
	    $sql->execute();

    endforeach;	

    
?>