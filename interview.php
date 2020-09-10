<?php $id=$_GET['id']; ?>
<?php require_once('header.php'); ?>

  <?php
   // CLIP SEMAINE
   $date = date('Y-m-d');
   $sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste WHERE id_interview="'.$id.'" LIMIT 1');
   $res = $sql->fetch(PDO::FETCH_OBJ);
   //
   $photo = $res->photo_interview;
   $texte_interview = $res->texte_interview;
   $nom_artiste = $res->nom_artiste;
   $date_debut = $res->date_debut_interview;
   //
   if($date_debut>$date){
    print "<script>window.location.href='interviews.php';</script>";
   }
   //
   
   
   
  ?>
  <ol class="breadcrumb"><li><a href="interviews.php">Toutes les interviews</a></li><li class="active"><?php echo $nom_artiste; ?></li></ol>
   <div class="top_nom_artiste">interview<br>de <?php echo $nom_artiste; ?></div>
   
   
   <div class="clip_video">
      <div class="diapo">
             
         <div class="image overflow-hidden relative"><img src="<?php echo $photo; ?>" class="center-cropped" /></div>
           
      </div>
  </div>
  
  <div class="infos_top_semaine"><?php echo $texte_interview; ?></div>
  
  
  
<?php require_once('footer.php'); ?>