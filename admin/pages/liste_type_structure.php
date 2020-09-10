<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("type_structure","id_type_structure='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_type_structure.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">type structure</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_type_structure.php"><input type="button" value="Ajouter un type de structure" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="3"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	if($_POST['search']){
		$sql->select("type_structure","nom_type_structure LIKE '%".$_POST['search']."%'","*","ORDER BY nom_type_structure");
	}else{
		$sql->select("type_structure","","*","ORDER BY nom_type_structure");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_type_structure'];
		$nom = utf8_encode($res['nom_type_structure']);
		$description = utf8_encode($res['description_type_structure']);
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
    <tr class="<?php echo $color; ?>"><td><a href="type_structure-<?php echo $id; ?>.php"><?php echo $nom; ?></a></td><td><?php echo $description; ?></td><td width="20"><a href="type_structure-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20"><a href="liste_type_structure-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>