<div id="comm">
<?php
	$sql = $pdo->query("SELECT * FROM commentaire INNER JOIN utilisateur ON utilisateur.id_utilisateur = commentaire.id_utilisateur WHERE type_commentaire='".$type_commentaire."' AND id_artiste='".$id."' ORDER BY date_commentaire DESC");
	while($res = $sql->fetch(PDO::FETCH_OBJ)){
?>
  <div class='commentaire'>
    <aside> <span class="nom"><?php echo $res->prenom_utilisateur; ?> <?php echo $res->nom_utilisateur; ?></span> <span class="date"><?php echo date("d/m/Y à H:i", strtotime($res->date_commentaire)); ?></span> </aside>
    <article><?php echo $res->texte_commentaire; ?></article>
    <div class="clear"></div>
  </div>
<?php
	}
?> 

<?php if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""){  ?>
  <div class="new_com">
    <span class="titre">laissez un commentaire</span>
    <form id="commentaireForm">
    	<textarea name="comment"></textarea>
        <input type="hidden" name="type_commentaire" value="<?php echo $type_commentaire; ?>" />
        <input type="hidden" name="id_artiste" value="<?php echo $id; ?>" />
    </form>
    <div class="add_comm">Envoyer</div>
    <div class="clear"></div>
  </div>
  <?php } ?>
</div>

<script>
$(document).ready(function() {

	//
	$('.new_com .add_comm').click(function(){
		
		
		$.ajax({ 
		   type: "POST", 
		   url: "add_comment.php", 
		   data: $('#commentaireForm').serialize(), 
		   success: function(msg){ 
				
			var current_href = $(location).attr('href');
			var current_title = $(document).attr('title');
			load_content(current_title,current_href);
			}
		   
		});
		return false; // ne change pas de page
	
	});

});
</script>
