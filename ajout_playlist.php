<?php
require_once("init.php");
require_once('cn.php');
$id_chanson = $_GET['id'];
//
if(isset($_POST['playlist']) && $_POST['playlist']!="0"){
	if($pdo->exec('INSERT INTO playlist_titre SET id_playlist="'.$_POST['playlist'].'", id_chanson="'.$id_chanson.'"')){
		echo "<script>parent.$.fancybox.close();</script>";
	}
}
if(isset($_POST['nom']) && $_POST['nom']!=""){
	$pdo->exec('INSERT INTO playlist SET nom_playlist="'.$_POST['nom'].'", id_utilisateur="'.$_SESSION['id_utilisateur'].'"');
    $lastInsertId = $pdo->lastInsertId();
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Ajouter une playlist</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body style="margin:0; padding:0; text-align:left; font-family:Arial, Helvetica, sans-serif; height:auto;">


<form action="ajout_playlist.php?id=<?php print $id_chanson; ?>" method="post">
        <div class="input-group input-group-lg  well well-xl">
        <select name="playlist" class="form-control">
            <option value="0">Sélectionnez une playlist</option>
        <?php
            $sql = $pdo->query("SELECT * FROM playlist WHERE id_utilisateur='".$_SESSION['id_utilisateur']."'");
            while($res = $sql->fetch(PDO::FETCH_OBJ)){

                $select = "";
                if($res->id_playlist == $lastInsertId) $select = "selected";

        ?>
            <option value="<?php echo $res->id_playlist; ?>" <?php print $select; ?> ><?php echo $res->nom_playlist; ?></option>
        <?php
            }
        ?>
        </select>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span></button>
        </span>
    </div>
    
</form>
<hr>
<form action="ajout_playlist.php?id=<?php print $id_chanson; ?>" method="post" class="form-inline container" style="width:75%;">
    <div class="input-group input-group-sm">
        <span class="input-group-addon" id="basic-addon1">ou</span>
        <input type="text" class="form-control" name="nom" placeholder="Nouvelle playlist">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default btn-sm">Créer</button>
        </span>
    </div>
</form>

</body>
</html>