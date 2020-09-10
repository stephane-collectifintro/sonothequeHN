$(document).ready(function() {
var audio = document.getElementById('player');
	var onPlay = false;
	$('.play').click(function(){
				if (onPlay) {
					$('.play').addClass("pause");
					$('.play').removeClass("play");
					audio.play();	
					onPlay = false;
				}else if(!onPlay){
					$('.pause').addClass("play");
					$('.pause').removeClass("pause");
					audio.pause();
					onPlay = true;
				}
			
		
	});
	
$('.rac_playlist').click(function()  {
                if ($('.ico_infos').css('visibility')=='hidden'){
                    $('.ico_infos').css('visibility', 'visible');
                } else {
                    $('.ico_infos').css('visibility', 'hidden');
                }
}); 




});