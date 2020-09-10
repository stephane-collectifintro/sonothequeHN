<?php 
$id = $_GET['id'];
$page = $_GET['page'];
$url = "http://sonotheque-normandie.com/".$page."-".$id.".php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sharer</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
function PopupCenter(pageURL, title,w,h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  return targetWin;
} 
$(function(){
	$("textarea").select().focus();
	$("textarea").click(function(){
		$(this).select();
	});
	
});
</script>

<style type="text/css">
	
	body{
		overflow: hidden;
	}
	
	img{
		height: 50px;
		width: 50px;

	}
	h3{
		line-height: 0;
    display: inline-block;
    vertical-align: top;
    margin: 24px 10px 0 0;
	}
	
</style>
</head>
<body>
	
<h3>Partagez sur </h3>
<a href="javascript:PopupCenter('http://www.facebook.com/sharer.php?p[url]=<?php print $url; ?>', 'Facebook share', 555, 620)"><img src="img/facebook.svg"></a>
<a href="javascript:PopupCenter('https://twitter.com/home?status=<?php print $url; ?>', 'Twitter share', 555, 620)"><img src="img/twitter.svg"></a>
<a href="javascript:PopupCenter('https://plus.google.com/share?url=<?php print $url; ?>', 'Google share', 475, 620)"><img src="img/googleplus.svg"></a>

<?php if ($page!="artiste"): ?>
<h4>embed code</div>
<textarea style="width:100%; height:45px;" ><iframe scrolling="no" frameborder="0" allowTransparency="false" src="http://www.sonotheque-normandie.com/xplayer2.php?id=<?php print $id; ?>&p=<?php print $page; ?>" height="389" width="750"></iframe></textarea>
<?php endif ?>
</body>
</html>