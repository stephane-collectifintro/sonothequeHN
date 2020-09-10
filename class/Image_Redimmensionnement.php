<?php
//require('class_Image_Redimmensionnement.php');
require('image_class.php');
$thumb = new Image(); 
$thumb->upload('image','aaa');
$thumb->dir('bbb');
$thumb->save();
/*if((isset($_FILES['image']['tmp_name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK))){
	
	//Image::resize($monImage,$maMiniature,$largeur,) // Cropera l'image exactement
	$monImage = $_FILES['image']['tmp_name'];
	
	$maMiniature = "mini-".$_FILES['image']['name'];
	$largeur = 200;
	$hauteur = 0;
	$thumb = new Image($monImage); 
	$thumb->width(200);
	$thumb->save();
	$image = new Image();
	if($image->upload($monImage,$_FILES['image']['name'])){
		$image->resize($_FILES['image']['name'],$maMiniature,$largeur,$hauteur); // Gardera le ratio mais avec la largeur indiquée
	}
}*/

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Document sans titre</title>
</head>
<form action="<?php echo $PHP_SELF; ?>" method="post" enctype="multipart/form-data">
	<input type="file" name="image" />
    <input type="submit" />
</form>


<body>
</body>
</html>