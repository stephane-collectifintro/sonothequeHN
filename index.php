<?php
session_start();
$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['artiste'] = array();
$_SESSION['album'] = array();

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Document sans nom</title>
<script>
document.location.href="home.php";
</script>
</head>

<body>
</body>
</html>