<div id="recherche_avance">
  <form onsubmit="return false">
  <select name="style" id="style">
  		<option value="">---</option>
  		<?php
		$req = $pdo->query("SELECT * FROM type_style ORDER BY nom ASC");
		while($res = $req->fetch(PDO::FETCH_OBJ)){
			$nom = stripslashes($res->nom);
			$id_style=$res->id_type_style;
			if(empty($nom)){
				$nom = "inconnu"; 
			}
		?>
        <option value="<?php echo $id_style; ?>"><?php echo $nom; ?></option>
        <?php
		}
		?>
  </select>
    
  
  <select name="ville" id="ville">
  		<option value="">---</option>
  		<?php
		$req = $pdo->query("SELECT ville FROM artiste GROUP BY ville ORDER BY ville ASC");
		while($res = $req->fetch(PDO::FETCH_OBJ)){
			$ville = stripslashes($res->ville);
			if($ville=="") $ville = "inconnu";
		?>
        <option><?php echo $ville; ?></option>
        <?php
		}
		?>
  
  </select>
  
  <select name="date" id="date">
  		<option value="">---</option>
  		<?php
		$req = $pdo->query("SELECT annee_sortie FROM album GROUP BY annee_sortie ORDER BY annee_sortie ASC");
		while($res = $req->fetch(PDO::FETCH_OBJ)){
			$annee_sortie = stripslashes(utf8_encode($res->annee_sortie));
			if($annee_sortie==0) $annee_sortie = "inconnu";
		?>
        <option><?php echo $annee_sortie; ?></option>
        <?php
		}
		?>
        
  
  </select>
  
    

  <div id="go"></div>
  </form>
</div>
