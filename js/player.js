$(document).ready(function() {

	// declaration variable
	
	var onPlay = false; 
	if ( $( "#player" ).length ) {
		var audio = document.getElementById('player');
		audio.volume = 0.5;
	}
	function timer(){
		var current_time;
		var time = Math.round(audio.currentTime) / 60;
		var minute = Math.floor(time);
		var seconde = Math.round((((time - Math.floor(time))*60))*100)/100;
		if (seconde < 10) {
			seconde = "0"+seconde;
		}
		if (minute < 10) {
			minute = "0"+minute;
		}
		if(audio.currentTime > 60){
			current_time = minute+"\:"+seconde;
		}else{
			current_time = "00\:"+seconde;
		}

		return current_time;
	}

	function duration_song(e){
		var duration_musique = 0 ;
		var time = Math.round(e) / 60;
		var minute = Math.floor(time);
		var seconde = Math.round((((time - Math.floor(time))*60))*100)/100;
		if (seconde < 10) {
			seconde = "0"+seconde;
		}
		if (minute < 10) {
			minute = "0"+minute;
		}
		duration_musique = minute+":"+seconde;

		return duration_musique;
	}

	$('.barre').click(function(e) {
 		// On récupère la position en X
		var durationTotal = audio.duration;
		//var posX = $(this).offset().left,posY = $(this).offset().top;
 		var posX=$(this).offset().left;
 		var d = e.pageX - posX;
 		var v = 485 / durationTotal;
 		var t = d / v;
 		audio.currentTime = t;
 		$(".pointer").css("width",d+"px");
 	});

	/*$('.img_album').click(function(){

		var first_song = $(this).parents("div")[1].children[1].children[0].children[0].id;
		var id_playlist =$(this).parents("div")[1].id;

		$("#player").attr('src',first_song);
		//Envoi info chanson dans infos
		$(".infos").fadeIn("fast");
		var titre = $(this).parents("div")[1].children[1].children[0].children[0].children[1].textContent, album = $(this).parents("div.infos_album")[0].children[1].textContent,img_album = $(this).find("img.jaquette").attr("src") ;
		$('.infos_title').html(titre+'<br/><span class="aniLight">'+album+'</span>');
		$('.infos_img img').attr('src',img_album);
		$('.play').addClass("pause");
		$('.play').removeClass("play");
		$('#'+id_playlist+' #playlist li').first('li').addClass("select_music");
		//ajout playlists
		var playlist = $(this).parents(".music_album").children("#playlist").html() ;
		$('.ico_infos').html(playlist);
		//envoi valeur album
		$.post("compteur.php", { type: "album", id: $(this).parents("div")[1].id } );

	});*/



	 $(".next").click(function(){

	 	$("#playlist_rac li.selected_music").next('li').click();

	});



	$(".before").click(function(){
		$("#playlist_rac li.selected_music").prev('li').click();
	});





	$('.play').click(function(){
	console.log('toto');
		if (onPlay) {
				console.log('titi');
			audio.pause();

		}else{
			console.log('tutu');
			audio.play();
			audio[0].autoplay = true;

		}

	});

	$('.icoPlaylist').click(function(){

		$("#playlist_rac").slideToggle(250);

	});












if ( $( "#player" ).length ) {
	audio.addEventListener("timeupdate",function(){


		var durationTotal = audio.duration;
		var pos_act = audio.currentTime ;
		var music_act = $(this).attr('value');

	
		onPlay = !audio.paused; // on récupère si le player est en train de jouer ou non
		

		if(pos_act <= durationTotal){

			$("#playlist li").each(function() {
					
					if(music_act === $(this).attr('value')) $(this).addClass("select_music");
					else $(this).removeClass("select_music");
		
			});

			$("#playlist_compte li").each(function() {

					if(music_act === $(this).attr('id')) $(this).addClass("select_music");
					else $(this).removeClass("select_music");
			});

			$(".playlist li.track").each(function() {
				
				if(music_act === $(this).attr('id')){
					
					$(this).addClass("select_music");
						//console.log(audio.paused);

					if(audio.paused == true){
						
						
						$(this).find("i.ico_play").removeClass("ico_pause");
					}else{
						$(this).find("i.ico_play").addClass("ico_pause");
					}


				}else{

					$(this).removeClass("select_music");
					$(this).find("i").removeClass("ico_pause");

				}


			});

			if (onPlay) {

				$('article.playlist').each(function(){

					if ( $('#playlist_rac ul').attr('id') == $(this).attr('id') ) {
						$(this).find('.album-send i').addClass('ico_pause');
					}else{
						$(this).find('.album-send i').removeClass('ico_pause');
					}

				});

				$('.play').addClass('pause');



			}else{

				$('.album-send i').removeClass('ico_pause');

				$('.play').removeClass('pause');

			}

			$("li.selected_music").each(function() {
				var titre = $(this).children("span.titre_song").text();
				var album = $(".infos_title .aniLight").text();
				$('.infos_title').html(titre+'<br/><span class="aniLight">'+album+'</span>');
			});
			var i=pos_act*(485/durationTotal);
			$(".pointer").css("width",i+"px");

			if(i > 0){

				$('#playlist ul li .noload').removeClass("loading");
				$('#playlist_compte ul li .noload').removeClass("loading");
				$(".playlist .loader").fadeOut(200);

			}

			var time = timer();
			$('.current_time').text(time);

			$('.durring_time').text(duration_song(durationTotal));
		}
		
		if(Math.floor(pos_act) == Math.floor(durationTotal/2) ){
console.log('test3');
			$.post("compteur.php", { type: "titre", id: $("audio#player").attr('value') },function(data){ console.log(data); } );


		}
		if(pos_act >= durationTotal){

			$("#playlist_rac li.selected_music").next('li').click();


		}
	});

}

});
