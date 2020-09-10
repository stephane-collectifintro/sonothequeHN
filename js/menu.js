$(document).ready(function() {
 
  $("#menu").hide();
  $(".bloc").hide();

	// declaration variable
	$addOrRemove = false;
	$addOrRemoveMusic = false;
	
	//Gestion menu deroulant
	$("#styleMusic").click(function() {
		  $("#bloc1").slideToggle('slow',function(){
			  	if ($addOrRemoveMusic) {
					$('#styleMusic').removeClass("select_menu");
					$('#styleMusic').addClass("noselect_menu");
					$addOrRemoveMusic = false;
		  		} else {  
			 		$('#styleMusic').removeClass("noselect_menu");
					$('#styleMusic').addClass("select_menu");
					$addOrRemoveMusic = true;
			 	}
		  });
	});
	
	
	$("#blocArtiste").click(function() {
  		 $("#bloc2").slideToggle('slow',function(){
			  	if ($addOrRemove) {
					$('#blocArtiste').removeClass("select_menu");
					$('#blocArtiste').addClass("noselect_menu");
					$addOrRemove = false;
		  		} else {  
			 		$('#blocArtiste').removeClass("noselect_menu");
					$('#blocArtiste').addClass("select_menu");
					$addOrRemove = true;
			 	}
		  });
	});
	
	
	$('#bloc1 ul li').click(function(){
		$('#bloc1 ul li').removeClass("select");
		$(this).toggleClass("select");
		$style = $(this).text();
	});
	
	$('#bloc2 ul li').click(function(){
		$('#bloc2 ul li').removeClass("select");
		$(this).toggleClass("select");
		$artiste = $(this).text();
	});

	
	
	$(".searchPlus").click(function() {
  		 $("#menu").slideToggle('slow');
	});

});