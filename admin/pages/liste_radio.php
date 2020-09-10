<?php

if(isset($_GET['id'])){
	
	$id = $_GET['id'];
	$sql = new sql();


	$sql->setQuery("DELETE FROM radio_titre WHERE id_radio=".$id);
	if($sql->execute()):

		$sql->setQuery("SELECT image_radio FROM radio WHERE id_radio=".$id);
		$sql->execute();
		$res = $sql->result();
		if(!empty($res['image_radio']) && is_readable("../".$res['image_radio'])):

			unlink('../'.$res['image_radio']);

		endif;
		
		$sql->setQuery("DELETE FROM radio WHERE id_radio=".$id);
		if($sql->execute()):

			print "<script>window.location.href='liste_radio.php';</script>";

		else:

			print "<script>alert('Probl\350me lors de la suppression de la radio')</script>";

		endif;
	
	else:

		print "<script>alert('Probl\350me lors de la suppression des titres de la radio')</script>";

	endif;
	
	
	
}
?>
<div id="liste">	
	<div class="titre">Radio</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_radio.php"><input type="button" value="Ajouter une radio" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="2"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("radio","titre_radio LIKE '%".$_POST['search']."%'","*","ORDER BY titre_radio");
	}else{
		$sql->select("radio","","*","ORDER BY titre_radio");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_radio'];
		$titre = utf8_encode($res['titre_radio']);
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="radio-<?php echo $id; ?>.php"><?php echo $titre; ?></a></td><td width="20" align="center"><a href="radio-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_radio-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>