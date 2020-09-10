<?php
header('HTTP/1.1 503 Service Unavailable');
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maintenance</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
	<div class="container"">
		<div class="row">
		
		<div class="well well-lg">
  			<div class="page-header"><h1>sonotheque-normandie.com</h1></div>
  			<p>Le site est en maintenance, nous serons de retour très rapidement .</p> 
			<?php print $_SERVER['REMOTE_ADDR']; ?>		
		</div>
		</div>
    	</div>
</body>
</html>