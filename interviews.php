<?php require_once('header.php'); ?>
<div class="page-header">
  <h1>Interviews</h1>
</div>
<div class="list-group">

<?php
$today = date('Y-m-d');
$sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste ORDER BY date_debut_interview DESC');
while($res = $sql->fetch(PDO::FETCH_OBJ)):
//
setlocale (LC_TIME, 'fr_FR.utf-8','fra');
$id = $res->id_interview;
$date_debut = $res->date_debut_interview;
$date = strftime('%d %b %Y',strtotime($date_debut));
$date_fin = $res->date_fin_interview;
$nom_artiste = $res->nom_artiste;
$texte = new texte();
$nom_artiste_url = str_replace('-','_',strtolower($texte->clean($nom_artiste)));


if($date_fin>$today){

  $active = "list-group-item-success";

}else{

  $active = "";

}

if($date_debut>$today){

  $active = "disabled";

?>
<a onclick='javascript:void(0);' class="list-group-item text-muted <?php print $active; ?>" style="color:#BBB !important"><span class="badge" style="background:#CCC;" >Prochainement</span> <?php echo $nom_artiste; ?></a>

<?php }else{ ?>

<a href="interview-<?php print $id; ?>-<?php print $nom_artiste_url; ?>.php" class="list-group-item <?php print $active; ?>"><span class="badge"><?php print $date; ?></span> <?php echo $nom_artiste; ?></a>

<?php
}
?>

  
  
  


  <?php endwhile; ?>
</div>
  
  
<?php require_once('footer.php'); ?>