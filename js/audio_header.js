

var start_sound = false;
	function loadSong(elt) {
		
      	if($(".infos").is(":hidden")){
			$(".infos").fadeIn("fast");
		}
		start_sound = true;
		$("#player").attr('src',elt.id);
		$('.play').addClass("pause");
		$('.play').removeClass("play");
		return false;
	}
	


	window.onload = function() {
		//$("#menu").slideUp('fast');
		$(".infos").hide();
		$(".ico_infos").hide();
	
		
		
		
		
	}
	

