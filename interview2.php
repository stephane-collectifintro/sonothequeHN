<?php $id=$_GET['id']; ?>
<?php require_once('header.php'); ?>

  <?php
   // CLIP SEMAINE
   $date = date('Y-m-d');
   $sql = $pdo->query('SELECT * FROM interview INNER JOIN artiste ON interview.id_artiste = artiste.id_artiste WHERE id_interview="'.$id.'" LIMIT 1');
   $res = $sql->fetch(PDO::FETCH_OBJ);
   //
   $photo = $res->photo_interview;
   $texte_interview = utf8_encode($res->texte_interview);
   $nom_artiste = utf8_encode($res->nom_artiste);
   
   
  ?>
   <div class="top_nom_artiste">interview<br>de <?php echo $nom_artiste; ?></div>
   
   <div class="clip_video">
    	<div class="diapo">
        <?php $dim = redim($photo,250,535); ?>
        
         <div class="image" style="overflow:hidden;"><img src="<?php echo $photo; ?>"  <?php echo $dim; ?> /></div>
           
   		</div>
  </div>
  
  <div class="infos_top_semaine"><?php echo $texte_interview; ?></div>
  
  
  
<?php require_once('footer.php'); ?>