<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("personne","id_personne='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_personne.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">personne</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_personne.php"><input type="button" value="Ajouter une personne" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="2"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("personne","nom_personne LIKE '%".$_POST['search']."%' OR prenom_personne LIKE '%".$_POST['search']."%'","*","ORDER BY nom_personne, prenom_personne");
	}else{
		$sql->select("personne","","*","ORDER BY nom_personne, prenom_personne");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_personne'];
		$nom = utf8_encode($res['nom_personne']);
		$prenom = utf8_encode($res['prenom_personne']);
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="personne-<?php echo $id; ?>.php"><?php echo $nom; ?> <?php echo $prenom; ?></a></td><td width="20" align="center"><a href="personne-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_personne-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>