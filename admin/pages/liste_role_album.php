<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("type_role","id_type_role='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_role_album.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">Rôle album</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_role_album.php"><input type="button" value="Ajouter un rôle" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="3"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select(" type_role","nom_type_role LIKE '%".$_POST['search']."%'","*","ORDER BY nom_type_role");
	}else{
		$sql->select(" type_role","","*","ORDER BY nom_type_role");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_type_role'];
		$nom = utf8_encode($res['nom_type_role']);
		$description = utf8_encode($res['description_role']);
	
		$string = new texte();
		$description = $string->cutString($description,50);
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="role_album-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td style="text-align:center;"><?php echo $description; ?></td><td width="20"><a href="role_album-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20"><a href="liste_role_album-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>