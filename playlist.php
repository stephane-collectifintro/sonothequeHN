
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
			$url = $_MUSIC_ROOT.$res->url_pj;
			$url = str_replace('.mp3', '.'.$file_format, $url);
			$id_chanson = $res->id_pj;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res->piste;
			$token = $url;
			//$token = uniqid('azertyuiop',false);
			//$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");

			/*if($q === FALSE):
				exit('Une erreur est survenue.');
			endif;*/

			if($id_chanson == $id_music ):
				echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			else:
				echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			endif;



		endwhile;

		print "</ul>";

	endif; /* end if radio */





	if ($type=="album"):



		$sql = $pdo->query("SELECT * FROM album INNER JOIN portfolio_sonotheque ON album.id_jaquette = portfolio_sonotheque.id_pj WHERE album.id_album=".$playlist);
		$res = $sql->fetch(PDO::FETCH_OBJ);

		$titre_album = $res->titre;
		$image = $_ROOT.$_MUSIC_ROOT.$res->url_pj;
		$id_artiste = $res->id_artiste;

		$s = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj WHERE chanson.id_album = ".$playlist." ORDER BY piste ASC");

		if($droit!=3):

			print '<h1>'.$titre_album.'</h1>';

			print '<a href="/artiste-'.$id_artiste.'.php"><img src="'.$image.'" alt="'.$titre_album.'" style="width:100%;"></a>';

			print "<ul id='".$playlist."' type='album'>";

			while($res = $s->fetch(PDO::FETCH_OBJ)):
				$id_titre = $res->id_pj;
				$titre = $res->nom;
				$url = $_MUSIC_ROOT.$res->url_pj;
				$url = str_replace('.mp3', '.'.$file_format, $url);
				$id_chanson = $res->id_pj;
				$getID3 = new getID3;
				$ThisFileInfo = $getID3->analyze($url);
				$duree = $ThisFileInfo['playtime_string'];
				//$duree=$res->duree;
				$piste = $res->piste;
				//$token = uniqid('azertyuiop',false);
				//$token = $token;
				$token = $url;

				//$q = $pdo->exec("INSERT INTO media_tokens SET token='".$token."', fichier='".$url."'");

				/*if($q === FALSE):
					exit('Une erreur est survenue.');
				endif;*/

				if($id_chanson == $id_music  ):
					echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
				else:
					echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
				endif;

			endwhile;

			print "<script>$(function(){ $.post('compteur.php', { type: 'album', id:".$playlist." }); }); </script>";

		endif; //fin if $droit



	endif; /* end if album */




	if ($type=="playlist"):



		$sql = $pdo->query("SELECT *
							FROM `playlist_titre`
							INNER JOIN chanson ON chanson.id_chanson=playlist_titre.id_chanson
							INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
							INNER JOIN album ON chanson.id_album = album.id_album
							INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
							WHERE id_playlist=".$playlist." ORDER BY ordre_playlist_titre");


		print "<ul id='".$playlist."' type='playlist'>";

	    while($res = $sql->fetch(PDO::FETCH_OBJ)):





			$id_titre = $res->id_pj;
			$titre = $res->nom;
			$url = $_MUSIC_ROOT.$res->url_pj;
			$url = str_replace('.mp3', '.'.$file_format, $url);
			$id_chanson = $res->id_pj;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res->piste;
			//$token = uniqid('azertyuiop',false);
			$token = $url;
			/*$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");

			if($q === FALSE):
				exit('Une erreur est survenue.');
			endif;*/

			if($id_chanson == $id_music ):
				echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			else:
				echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			endif;



		endwhile;

		print "</ul>";

	endif; /* end if playlist */






	if ($type=="track"):



		$sql = $pdo->query("SELECT *
        					FROM portfolio_sonotheque
        					INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj
        					INNER JOIN album ON album.id_album = chanson.id_album
        					INNER JOIN artiste ON album.id_artiste = artiste.id_artiste
        					WHERE chanson.id_chanson = ".$playlist);


		print "<ul id='".$playlist."' type='track'>";

	    $res = $sql->fetch(PDO::FETCH_OBJ);





		$id_titre = $res->id_pj;
		$titre = $res->nom;
		$url=$_MUSIC_ROOT.$res->url_pj;
		$url = str_replace('.mp3', '.'.$file_format, $url);
		$id_chanson = $res->id_pj;
		$getID3 = new getID3;
		$ThisFileInfo = $getID3->analyze($url);
		$duree = $ThisFileInfo['playtime_string'];
		//$duree=$res->duree;
		$piste = $res->piste;
		//$token = uniqid('azertyuiop',false);
		$token = $url;
		/*$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");

		if($q === FALSE):
			exit('Une erreur est survenue.');
		endif;*/

		if($id_chanson == $id_music ):
			echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
		else:
			echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
		endif;





		print "</ul>";

	endif; /* end if track */










	if ($type=="coup_coeur"):



		$sql = $pdo->query("SELECT *
							FROM `favori_titre`
							INNER JOIN chanson ON chanson.id_chanson=favori_titre.id_chanson
							INNER JOIN portfolio_sonotheque ON portfolio_sonotheque.id_pj = chanson.id_morceau
							INNER JOIN album ON chanson.id_album = album.id_album
							INNER JOIN artiste ON artiste.id_artiste = album.id_artiste
							WHERE id_utilisateur=".$playlist);


		print "<ul id='".$playlist."' type='coup_coeur'>";

	    while($res = $sql->fetch(PDO::FETCH_OBJ)):





			$id_titre = $res->id_pj;
			$titre = $res->nom;
			$url=$_MUSIC_ROOT.$res->url_pj;
			$url = str_replace('.mp3', '.'.$file_format, $url);
			$id_chanson = $res->id_pj;
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze($url);
			$duree = $ThisFileInfo['playtime_string'];
			//$duree=$res->duree;
			$piste = $res->piste;
			//$token = uniqid('azertyuiop',false);
			$token = $url;
			/*$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");

			if($q === FALSE):
				exit('Une erreur est survenue.');
			endif;*/

			if($id_chanson == $id_music ):
				echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			else:
				echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'" class="noclass"><span class="piste"></span><span class="titre_song">'.$titre.'</span> <span class="time">'.$duree.'</span><div class="noload"></div>';
			endif;



		endwhile;

		print "</ul>";

	endif; /* end if playlist */


endif; /* fin if action */

?>
