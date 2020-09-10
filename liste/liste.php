 <!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Document sans titre</title>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>   
    <script>
        $(document).ready(function() {
            setInterval("location.reload(true)", 15000);
        });
    </script>
</head>

<body>
<?php
require('../cn.php');

$sql = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau=portfolio_sonotheque.id_pj ORDER BY url_pj");
while($res = $sql->fetch(PDO::FETCH_OBJ)){
	
	
	if(!file_exists(utf8_encode("../musik_sonotk/".$res->url_pj))){
		echo utf8_encode("../musik_sonotk/".$res->url_pj)."<br>";
	}
	
}
?>
</body>
</html>
