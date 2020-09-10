<?php require_once('header.php'); ?>

    <div id="center">
    <div class="alphabet">
    <?php
		$alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
		
		$l=$alphabet[0];
		if(isset($_GET['l']) && !empty($_GET['l'])){
			$l = $_GET['l'];
		}
					
		for($i=0;$i<count($alphabet);$i++){
			$lettre=$alphabet[$i];
			$sql = $pdo->query("SELECT * FROM artiste WHERE nom_artiste LIKE '".$lettre."%' ORDER BY nom_artiste");
			
			if($sql->rowCount()){
				if($l==$lettre){ $on="class='on'"; }else{ $on=""; };
				echo "<a href='artistes-".$lettre.".php' title='Artistes - ".strtoupper($lettre)."'><span ".$on.">".strtoupper($lettre)."</span></a>";
			}else{
				echo "<span class='off'>".strtoupper($lettre)."</span>";	
			}
		}
	?>
    </div>
      <div class="namesArtiste">
        <?php 
				
								
					
					
					echo "<header>".$l."</header>";
					echo "<ul>";
					
					$sql = $pdo->query("SELECT * FROM artiste WHERE nom_artiste LIKE '".$l."%' ORDER BY nom_artiste");		
					
					while($res=$sql->fetch(PDO::FETCH_OBJ)){
						
						$id = $res->id_artiste;
						$nom = stripslashes($res->nom_artiste);
						
						$texte = new texte();
						$nom_url = str_replace('-','_',$texte->clean(strtolower($nom)));
						
						
				?>
        <li><a href="artiste-<?php echo $id; ?>-<?php echo $nom_url ?>.php" title="<?php echo $nom; ?>"><?php echo $nom; ?></a> </li>
        <?php
                                
                        }
                        echo'</ul>';
                    
                    ?>
      </div>
      <?php require_once('bottom.php') ?>
    </div>
  
<?php require_once('footer.php'); ?>