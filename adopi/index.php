<?php
if(isset($_POST['telecharger'])){
	header("content-type: application/vnd.ms-excel");
	header("content-disposition: attachment; filename=liste_adopi_".date('d-m-Y-H-i-s').".csv");
	
	//=======================================

	require("../cn.php");
	$csv = "Identifiant;Titre;AlbumTitre;Auteur(s);Éditeurs;Version;Réalisateur(s);Producteur(s);Artiste(s);Type oeuvre"."\n"; // le \n final entre " "
	

	$sql = $pdo->query("SELECT * 
						FROM portfolio_sonotheque 
						INNER JOIN chanson ON portfolio_sonotheque.id_pj=chanson.id_morceau 
						INNER JOIN album ON chanson.id_album=album.id_album
						INNER JOIN artiste ON artiste.id_artiste=album.id_artiste
						ORDER BY titre ASC, piste ASC");
	
	// construction de chaque ligne
	


	while($res = $sql->fetch(PDO::FETCH_OBJ)){

		$producteur = array();
		$auteur = array();
		$editeur = array();

		//PRODUCTEUR
		$sql2 = $pdo->query("SELECT * FROM structure_role_album INNER JOIN type_role_structure_album ON structure_role_album.id_type_role_structure_album = type_role_structure_album.id_type_role_structure_album INNER JOIN structure_sonotk ON structure_sonotk.id_structure = structure_role_album.id_structure WHERE nom_type_role_structure_album='Production' AND id_album = '".$res->id_album."'");
		//echo "SELECT * FROM structure_role_album INNER JOIN type_role_structure_album ON structure_role_album.id_type_role_structure_album = type_role_structure_album.id_type_role_structure_album INNER JOIN structure_sonotk ON structure_sonotk.id_structure = structure_role_album.id_structure WHERE nom_type_role_structure_album='Production' AND id_album = '".$res->id_album."'";
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$producteur[]=$res2->nom_structure;
		}
		$producteur = implode(', ', $producteur);

		//AUTEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='1' AND id_pj = '".$res->id_pj."'");
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$auteur[]=$res2->nom_personne;
		}
		$auteur = implode(', ', $auteur);

		//EDITEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='3' AND id_pj = '".$res->id_pj."'");
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$editeur[]=$res2->nom_personne;
		}
		$editeur = implode(', ', $editeur);


		$csv .= ";".$res->nom.";".$res->titre.";".$auteur.";".$editeur.";;;".$producteur.";".$res->nom_artiste.";Oeuvres musicales"."\n";
		
		
	}
	//toutes les donnees sont en chaine, on va envoyer le jus :
	echo $csv;

	//=======================================



	/*require('../cn.php');
	$sql = $pdo->query("SELECT * 
						FROM portfolio_sonotheque 
						INNER JOIN chanson ON portfolio_sonotheque.id_pj=chanson.id_morceau 
						INNER JOIN album ON chanson.id_album=album.id_album
						INNER JOIN artiste ON artiste.id_artiste=album.id_artiste
						ORDER BY nom_artiste ASC, piste ASC");
	




	$date = date('Y-m-d');
	$file = ;
	
	$fp = fopen($file, 'w');
	
	$ligne = "Identifiant;Titre;AlbumTitre;Auteur(s);Éditeurs;Version;Réalisateur(s);Producteur(s);Artiste(s);Type oeuvre";
	fputcsv($fp,explode(';',$ligne),';');
	
	$ligne = "";
	fputcsv($fp,explode(';',$ligne),';');
	
	$producteur = array();
	$auteur = array();
	$editeur = array();


	while($res = $sql->fetch(PDO::FETCH_OBJ)){

		//PRODUCTEUR
		$sql2 = $pdo->query("SELECT * FROM structure_role_album INNER JOIN type_role_structure_album ON structure_role_album.id_type_role_structure_album = type_role_structure_album.id_type_role_structure_album INNER JOIN structure_sonotk ON structure_sonotk.id_structure = structure_role_album.id_structure WHERE nom_type_role_structure_album='Production' AND id_album = '".$res->id_album."'");
		while($res2 = fetch(PDO::FETCH_OBJ)){
			$producteur[]=$res2->nom_structure;
		}
		$producteur = implode(', ', $producteur);

		//AUTEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='1' AND id_pj = '".$res->id_pj."'");
		while($res2 = fetch(PDO::FETCH_OBJ)){
			$auteur[]=$res2->nom_personne;
		}
		$auteur = implode(', ', $auteur);

		//EDITEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='3' AND id_pj = '".$res->id_pj."'");
		while($res2 = fetch(PDO::FETCH_OBJ)){
			$editeur[]=$res2->nom_personne;
		}
		$editeur = implode(', ', $editeur);


		$ligne = ";
					".$res->titre.";
					".$res->titre.";
					".$res->nom.";
					".$auteur.";
					".$editeur.";
					;
					;
					".$producteur.";
					".$res->nom_artiste.";
					Oeuvres musicales";
		fputcsv($fp,explode(';',$ligne),';');
		
	}
	fclose($fp);*/

	
}else{
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Document sans titre</title>
</head>
<body>

<div style="text-align:center;">
<form action="index.php" method="post" ><input type="submit" name="telecharger" value="télécharger la dernière liste ADOPI" style="padding:30px 50px; background-color:#069; color:#FFF; margin-top:50px; font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-transform:uppercase; border:3px solid #09F; cursor:pointer;" /></form>




<?php 
require("../cn.php");
	$csv .= "Identifiant;Titre;AlbumTitre;Auteur(s);Éditeurs;Version;Réalisateur(s);Producteur(s);Artiste(s);Type oeuvre"."\n"; // le \n final entre " "
	

	$sql = $pdo->query("SELECT * 
						FROM portfolio_sonotheque 
						INNER JOIN chanson ON portfolio_sonotheque.id_pj=chanson.id_morceau 
						INNER JOIN album ON chanson.id_album=album.id_album
						INNER JOIN artiste ON artiste.id_artiste=album.id_artiste
						ORDER BY nom_artiste ASC, piste ASC");
	
	// construction de chaque ligne
	


	while($res = $sql->fetch(PDO::FETCH_OBJ)){

		$producteur = array();
		$auteur = array();
		$editeur = array();

		//PRODUCTEUR
		$sql2 = $pdo->query("SELECT * FROM structure_role_album INNER JOIN type_role_structure_album ON structure_role_album.id_type_role_structure_album = type_role_structure_album.id_type_role_structure_album INNER JOIN structure_sonotk ON structure_sonotk.id_structure = structure_role_album.id_structure WHERE nom_type_role_structure_album='Production' AND id_album = '".$res->id_album."'");
		//echo "SELECT * FROM structure_role_album INNER JOIN type_role_structure_album ON structure_role_album.id_type_role_structure_album = type_role_structure_album.id_type_role_structure_album INNER JOIN structure_sonotk ON structure_sonotk.id_structure = structure_role_album.id_structure WHERE nom_type_role_structure_album='Production' AND id_album = '".$res->id_album."'";
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$producteur[]=$res2->nom_structure;
		}
		print_r($producteur);
		$producteur = implode(', ', $producteur);

		//AUTEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='1' AND id_pj = '".$res->id_pj."'");
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$auteur[]=$res2->nom_personne;
		}
		$auteur = implode(', ', $auteur);

		//EDITEUR
		$sql2 = $pdo->query("SELECT * FROM type_role_personne_titre INNER JOIN role_personne_titre ON type_role_personne_titre.id_type_role_personne_titre = role_personne_titre.id_type_role_personne_titre WHERE type_role_personne_titre.id_type_role_personne_titre='3' AND id_pj = '".$res->id_pj."'");
		while($res2 = $sql2->fetch(PDO::FETCH_OBJ)){
			$editeur[]=$res2->nom_personne;
		}
		$editeur = implode(', ', $editeur);


		$csv = ";".$res->titre.";".$res->titre.";".$res->nom.";".$auteur.";".$editeur.";;;".$producteur.";".$res->nom_artiste.";Oeuvres musicales"."\n";
		
		
	}
	//toutes les donnees sont en chaine, on va envoyer le jus :
	echo $csv;
?>





</div>

</body>
</html>
<?php
}
?>
