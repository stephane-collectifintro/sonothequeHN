<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("complement_artiste","id_structure='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_complement_artiste.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">complement artiste</div>
	<table>
    <tr><td align="right" colspan="5"></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="3"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("complement_artiste","texte_complement_artiste LIKE '%".$_POST['search']."%'","*","ORDER BY id_complement_artiste");
	}else{
		$sql->select("complement_artiste","","*","ORDER BY id_complement_artiste");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_complement_artiste'];
		$mail = utf8_encode($res['mail_complement_artiste']);
		$texte = utf8_encode($res['texte_complement_artiste']);
		$string = new texte();
		$texte = $string->cutString($texte,50);
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="complement_artiste-<?php echo $id; ?>.php"><?php echo $mail; ?></a></td><td><?php echo $texte; ?></td><td width="20"><a href="complement_artiste-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20"><a href="liste_complement_artiste-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>