<?php require_once("init.php"); ?>
<?php require_once("cn.php"); ?>

<a href="mon_compte.php" title="mon compte"><strong style="text-transform:uppercase;">> Mon compte</strong></a>
<br><br>
<div id="myplaylist">
  <header>
    <h2>Mes playlists</h2>
  </header>
  <div class="liste">
    <ul>
    	<?php
			
			$sql = $pdo->query("SELECT * FROM playlist WHERE id_utilisateur='".$_SESSION['id_utilisateur']."' ORDER BY nom_playlist ASC");
			while($res = $sql->fetch(PDO::FETCH_OBJ)){
				$id_playlist = $res->id_playlist;
				$nom_playlist = stripslashes($res->nom_playlist);
				if($id_playlist==$_GET['id']){
					$class = "class='on'";
				}else{
					$class = "";
				}
		?>
      
      	<li <?php echo $class; ?> >
        	<a href="mon_compte_playlist-<?php echo $id_playlist; ?>.php" title="Ma playlist <?php echo $nom_playlist; ?>">> <?php echo $nom_playlist; ?></a>
            <div class="plus" rel="<?php echo $id_playlist; ?>" data-fancybox-type="iframe" style="transform:rotate(45deg); -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg);"></div>
       	</li>
        
      
		  <?php
                }
          ?>
    </ul>
  </div>
</div>

<br> 
<input type="text" name="newplaylist" style="width:100%; margin-bottom:5px;"><br><input type="button" value="Ajouter une playlist" id="addplaylist" style="width:100%;" />




<script>
			$(document).ready(function() {

				$('#myplaylist .plus').click(function(){
					//alert("id="+$(this).attr('rel')+"&type=playlist");
				
					$.ajax({ 
					   type: "POST", 
					   url: "suppr_playlist.php", 
					   data: "id="+$(this).attr('rel')+"&type=playlist", 
					   success: function(msg){ 
		
						  	var current_href = 'mon_compte.php';
							var current_title = 'Mon compte';
							load_content(current_title,current_href);
						  
				   		}
					   
					});
					return false; // ne change pas de page
				});
				
				$('#addplaylist').click(function(){
					$.ajax({ 
					   type: "POST", 
					   url: "add_playlist.php", 
					   data: "nom="+$("input[name='newplaylist']").val(), 
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
