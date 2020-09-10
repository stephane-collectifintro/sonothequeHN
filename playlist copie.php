
<?php

require("cn.php");
require('detect_browser.php');
require_once('class/getid3/getid3.php'); 
//

if(isset($_POST['action']) ):

	$type = $_POST['action'];
	$playlist = $_POST['id_playlist'];

	if ($type=="radio"):
	
		// radio

		$sql = $pdo->query("SELECT * 
							FROM `radio_titre` 
							INNER JOIN chanson ON chanson.id_chanson=radio_titre.id_chanson
							INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
							INNER JOIN album ON chanson.id_album = album.id_album
							INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
							WHERE id_radio=".$playlist." ORDER BY ordre_radio_titre ASC");

		
		print "<ul id='".$playlist."' type='radio'>";

	    while($res = $sql->fetch(PDO::FETCH_OBJ)):

			
			


			$id_titre = $res->id_pj;
			$titre = $res->nom;
			$url=$_MUSIC_ROOT.$res->url_pj;
			$id_chanson = $res->id_pj;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res->piste;
			//$token = uniqid('azertyuiop',false);
			$token = $url;			
			$token = str_replace('.mp3', '.'.$file_format, $token);
			$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
				
			if($q === FALSE):		
				exit('Une erreur est survenue.');		
			endif;
			
			if($id_chanson == $id_music ):
				echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';	
			else:
				echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			endif;



		endwhile;

		print "</ul>";


	else:


		$sql = $pdo->query("SELECT * FROM album WHERE album.id_album=".$playlist);		
		$res = $sql->fetch(PDO::FETCH_OBJ);
		$droit = $res->gestion_droit;

		$s = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$id_playlist." ORDER BY piste ASC");

		if($droit!="Pas d'autorisation"):

			print "<ul id='".$id_playlist."' type='album'>";
			
			while($res = $s->fetch(PDO::FETCH_OBJ)):
				$id_titre = $res->id_pj;
				$titre = $res->nom;
				$url=$_MUSIC_ROOT.$res->url_pj;
				$id_chanson = $res->id_pj;
				$getID3 = new getID3;
				$ThisFileInfo = $getID3->analyze($url);
				$duree = $ThisFileInfo['playtime_string'];
				//$duree=$res->duree;
				$piste = $res->piste;
				//$token = uniqid('azertyuiop',false);
				$token = $url;			
				$token = str_replace('.mp3', '.'.$file_format, $token);
				
				$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
					
				if($q === FALSE):		
					exit('Une erreur est survenue.');		
				endif;
				
				if($id_chanson == $id_music  ):
					echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';	
				else:
					echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
				endif;

			endwhile;

		endif; //fin if $droit



	endif;






else:


	// ALBUM
	
	$id_album = $_POST["id"];
	$id_music = $_POST["id_music"];
	$browser = $_POST["musik"];
	$pos = strstr($browser,".ogg");	
	$sql = $pdo->query("SELECT * FROM album WHERE album.id_album=".$id_album);		
	$res2 = $sql->fetch(PDO::FETCH_OBJ);
	$droit = $res2->gestion_droit;

	$s = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$id_album." ORDER BY piste ASC");

	if($droit!="Pas d'autorisation"):

		print "<ul id='".$id_album."' type='album'>";
		
		while($res = $s->fetch(PDO::FETCH_OBJ)):
			$id_titre = $res->id_pj;
			$titre = utf8_encode($res->nom);
			$url=$_MUSIC_ROOT.$res->url_pj;
			$id_chanson = $res->id_pj;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res->piste;
			//$token = uniqid('azertyuiop',false);
			$token = $url;			
			if($pos!==false)$token = str_replace('.mp3', '.ogg', $token);
			$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
				
			if($q === FALSE):		
				exit('Une erreur est survenue.');		
			endif;
			
			if($id_chanson == $id_music  ):
				echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';	
			else:
				echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			endif;

		endwhile;

	else:

?>

	<script>

		$("#playlist ul li").click(function(){
		    $('.rac_playlist').css('visibility', 'hidden');
		    $('.infos').css('visibility', 'hidden');
		    $('#playlist_rac').css('visibility', 'hidden');
		});

	</script>

	<?php endif; ?>

<?php endif; ?>