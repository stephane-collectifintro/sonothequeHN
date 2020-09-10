<?php

$fp = fopen('file.csv', 'w');  
 
$list5 = array("Peter de la villardière de l'eau;Griffin;Oslo;Norway","Glenn;Quagmire;Oslo;Norway");
foreach ($list5 as $line){
    fputcsv($fp,explode(';',$line), ';');
}
fclose($fp);  
?> 