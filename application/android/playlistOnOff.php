 <?php

require("../../cn.php");
//
	$id = $_GET['pid'];
	$onOff = $_GET['onOff'];
	$onOff == true ? "1":"0";
	/*$id = 98;
	$onOff = "false";*/
	if ($onOff == "true") $onOff = 1;
	else $onOff = 0;
	$pdo->exec("UPDATE playlist SET publique_playlist='".$onOff."' WHERE id_playlist=".$id);

?>

