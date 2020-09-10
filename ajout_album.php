<?php
require_once('cn.php');
$id = $_GET['id'];

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Ajouter une playlist</title>
</head>

<body style="width:600px; height:480px; margin:0; padding:0; text-align:left; font-family:Arial, Helvetica, sans-serif;">


<div style="background-color:#DDD; padding:10px; font-size:10px;">
<form action="<?php echo $PHP_SELF; ?>" method="post">
	<textarea style="padding:5px; width:360px; width: 550px; height: 150px;" />
    	<iframe name="partager" SRC="http://sonotheque-hn.com/player_sonotheque_hn.php?id=<?php echo $id; ?>" scrolling="no" height="270" width="528" FRAMEBORDER="no"></iframe>
    </textarea>
  </form>
</form>
</div>
</body>
</html>