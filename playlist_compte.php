<?php

require("cn.php");
require_once('class/getid3/getid3.php'); 
//
$id_playlist = $_POST["id"];
$id_music = $_POST["id_music"];
$browser = $_POST["musik"];
$pos = strstr($browser,".ogg");
						
				$s = $pdo->query("SELECT * FROM portfolio_sonotheque INNER JOIN chanson ON chanson.id_morceau = portfolio_sonotheque.id_pj INNER JOIN playlist_titre ON chanson.id_chanson = playlist_titre.id_chanson INNER JOIN album ON album.id_album = chanson.id_album INNER JOIN artiste ON album.id_artiste = artiste.id_artiste WHERE playlist_titre.id_playlist   = ".$id_playlist);
				while($res = $s->fetch(PDO::FETCH_OBJ)){
					
					$id_playlist_titre = $res->id_playlist_titre;
					
					$nom_artiste = $res->nom_artiste;
					$id_titre = $res->id_pj;
					$titre = utf8_encode($res->nom);
					$url=$_MUSIC_ROOT.$res->url_pj;
					$id_chanson = $res->id_chanson;
					$getID3 = new getID3;
					$ThisFileInfo = $getID3->analyze($url);
					$duree = $ThisFileInfo['playtime_string'];
					//$duree=$res->duree;
					$piste = $res->piste;
					//$token = uniqid('azertyuiop',false);
					$token = $url;		
					if($pos!==false)$token = str_replace('.mp3', '.ogg', $token);							
					$q = $pdo->exec("INSERT INTO media_tokens SET token='$token', fichier='".$url."'");
						
					if($q === FALSE) {
					
						exit('Une erreur est survenue.');
					
					}
				
					
					if($id_music == $id_titre  ){
					echo '<li onclick="javascript:loadSong(this); selectSong(this)" id="'.$token.'" value="'.$id_titre.'" class="selected_music"><span class="piste">'.$piste.'</span><span class="titre_song">'.$titre.'</span><span class="time"> <i>('.$nom_artiste.')</i> '.$duree.'</span><div class="noload"></div><div class="plus" rel="'.$id_playlist_titre.'" data-fancybox-type="iframe" style="transform:rotate(45deg); -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg);"></div></li>';
					}else{
					echo '<li onclick="javascript:loadSong(this)" id="'.$token.'" value="'.$id_titre.'"><span class="piste" class="noclass">'.$piste.'</span><span class="titre_song">'.$titre.'</span><span class="time"> <i>('.$nom_artiste.')</i> '.$duree.'</span><div class="noload"></div><div class="plus" rel="'.$id_playlist_titre.'" data-fancybox-type="iframe" style="transform:rotate(45deg); -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg);"></div></li>';
					}
				}
				
?>