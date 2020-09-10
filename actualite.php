<?php $id=$_GET['id']; ?>
<?php require_once('header.php'); ?>


  	<?php 
		
		$sql = $pdo->query("SELECT * FROM actualite WHERE id_actualite=".$id);
		$res = $sql->fetch(PDO::FETCH_OBJ);
		//
		$titre = stripslashes($res->titre_actualite);
		$texte = nl2br(stripslashes($res->texte_actualite));
		$photo = stripslashes($res->photo_actualite);
		$date = stripslashes($res->date_actualite);
	?>
    <?php if($photo!=""){ ?>
    <div class="photo">
    	<div class="titre_actu"><?php echo $titre; ?></div>
    	<div class="diapo">
        	<div class="image" style="background-image:url(<?php echo $_ROOT.$photo; ?>);"></div>
   		</div>
   	</div>
    <script>
	$(document).ready(function() {
	
		//
		$('#fbimage').attr('href','<?php echo $_ROOT.$photo; ?>');
		$('#fbogimage').attr('content','<?php echo $_ROOT.$photo; ?>');  
				
	});
	</script>
    <?php }else{ ?>
		<div class="titre_actu"><?php echo $titre; ?></div>
	<?php } ?>
      <div class="texte_actu"><?php echo $texte; ?></div>
      <div class="red_line"></div>
      <!--FACEBOOK LIKE-->
      
      <div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        
      <div class="fb-like left" data-href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false" style="height:40px;"></div>&nbsp;&nbsp;&nbsp;
      
      <!--TWITTER LIKE-->
      
      
      
      <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
	  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
       
    
  
<?php require_once('footer.php'); ?>