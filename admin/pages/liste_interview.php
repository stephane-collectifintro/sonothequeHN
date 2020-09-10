<?php
$Jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
$Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
?>
<?php

if(isset($_GET['id'])){
	$sql = new sql();
	$sql->delete("interview","id_interview='".$_GET['id']."'");
	//echo $sql->getQuery();
	if($sql->execute()){
		echo "<script>window.location.href='liste_interview.php';</script>";	
	}
}
?>
<div id="liste">	
	<div class="titre">interview</div>
	<table>
    <tr><td align="right" colspan="5"><a href="ajout_interview.php"><input type="button" value="Ajouter une interview" /></a></td></tr>
    <tr class="top"><td align="left"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="search" name="search" placeholder="Rechercher" value="<?php echo $_POST['search'] ?>"></form></td><td colspan="4"></td></tr>
	<?php 
	
	$ligne = true;
	
	$sql = new sql();
	
	if($_POST['search']){
		$sql->select("interview INNER JOIN artiste ON interview.id_artiste=artiste.id_artiste","titre LIKE '%".$_POST['search']."%'","","ORDER BY date_debut_interview DESC");
	}else{
		$sql->select("interview INNER JOIN artiste ON interview.id_artiste=artiste.id_artiste","","","ORDER BY date_debut_interview DESC");
	}
	$sql->execute();
	while($res = $sql->result()){
		
		$id = $res['id_interview'];
		$date = $res['date_debut_interview'];
		$date = $Jour[date("w", strtotime($date))]." ".date("d", strtotime($date))." ".$Mois[date("n", strtotime($date))-1]." ".date("Y", strtotime($date));
			
		$id_artiste = $res['id_artiste'];
		$artiste=stripslashes($res['nom_artiste']);
		
		//
		if($ligne){
			$color = "fonce";
			$ligne=!$ligne;
		}else{
			$color = "clair";
			$ligne=!$ligne;
		}
		
	?>
    <tr class="<?php echo $color; ?>"><td><a href="interview-<?php echo $id; ?>.php"><?php echo $date; ?></a></td><td><a href="album-<?php echo $id_album; ?>.php"><?php echo $nom; ?></a></td><td><em><a href="artiste-<?php echo $id_artiste; ?>.php"><?php echo utf8_encode($artiste); ?></a></em></td><td width="20" align="center"><a href="interview-<?php echo $id; ?>.php"><div class="bt_modify"></div></a></td><td width="20" align="center"><a href="liste_interview-<?php echo $id; ?>.php" onclick="return confirm('Voulez vous vraiment supprimer ?')"><div class="bt_delete"></div></a></td></tr>
    <?php
	}
	?>
    </table>
	
</div>