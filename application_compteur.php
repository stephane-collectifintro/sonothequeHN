<?php
require('cn.php');
$sql = $pdo->exec("UPDATE portfolio_sonotheque SET counter_pj = counter_pj+1 WHERE id_pj=".$_POST['id']);

?>