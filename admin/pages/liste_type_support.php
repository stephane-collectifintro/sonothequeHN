<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("type_support","id_type_support='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_support.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">type support</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_type_support.php"><input type="button" value="Ajouter un support" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="4"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("type_support","nom_type_support LIKE '%".$_POST['search']."%'","*","ORDER BY nom_type_support");
	}else{
		$sql->select("type_support","","*","ORDER BY nom_type_support");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_type_support'];
		$nom = utf8_encode($res['nom_type_support']);
	//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="type_support-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td width="20"><a href="type_support-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20"><a href="liste_type_support-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>