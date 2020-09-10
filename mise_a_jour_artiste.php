<?php require_once('header.php'); ?>

    <div id="center">
    <div class="resultat">
        <?php
		$date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-14-date('N')+1, date('Y')));
		
		//---ARTISTE
		$sql = $pdo->query("SELECT * FROM artiste WHERE date_maj_artiste>='".$date."'");
		if($sql->rowCount()>0){
			echo "<ul>";
			?>
			 
			<?php
			$color = "FFF";
			while($res=$sql->fetch(PDO::FETCH_OBJ)){
				
				$id = $res->id_artiste;
				$nom = stripslashes($res->nom_artiste);
				$texte = new texte();
				$nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
						
				if($color=="FFF"){
					$color = "F4F4F4";
				}else{
					$color = "FFF";	
				}
					
			?>
			<li style="background-color:#<?php echo $color; ?>;"><span><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a></span><div class="clear"></div></li>
			<?php                     
			}
			echo'</ul>';
		}else{
			echo "<div style='font-size:14px; text-align:center; color:#FFF; line-height:30px; background-color:#CCC;'>Aucune mise à jour d'artiste récente</div>";
		}
		?>
        
      <?php require_once('bottom.php') ?>
    </div>
    </div>
  
<?php require_once('footer.php'); ?>