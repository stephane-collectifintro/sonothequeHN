
<?php 

	require('../../cn.php'); 
	require('../../class/sql.class.php');


    $sql = new sql();
    $sql->setQuery('SELECT * FROM album WHERE id_artiste='.$_POST['id_artiste']);
    //print $sql->getQuery();
    $sql->execute();
    
    ?>
<select name="album" >
    <option value="0">- Choisir un album -</option>
   
	<?php while($res = $sql->result()): ?>

    <option value="<?php print $res['id_album']; ?>"><?php print utf8_encode(stripslashes($res['titre'])); ?></option>

    <?php endwhile; ?>
</select>
<a href="" class="lien_next" id="submit_album"></a>

<script>
	$(function() {
	  
		$('#submit_album').click(function(){
			//
			$.ajax({
		       url : 'views/get_select_tracks.php',
		       type : 'POST',
		       data : 'id_album=' + $('#selection select').val(),
		       success : function(msg){ // code_html contient le HTML renvoyé
		          $("#selection").html(msg)
		       }
		    });
			//
			return false;
		});

	});
</script>