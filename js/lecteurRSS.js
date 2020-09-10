$(document).ready(function() {
	var fluxRSS = "http://fabrikasons.com/?feed=gigpress"; //URL du flux
	var stockFluxRSS = []; // stockage des éléments du flux
	var retourHtml = "";

	$.ajax({
		type: "GET",
		url: fluxRSS, // appel de l'Url du flux RSS
		success : function(msg){ // code_html contient le HTML renvoyé
			  console.log(msg)
		}
	});

	function processusOK (xml){



			 $(xml).find('item').each( function(id,valeur){ //parcour de chaque élément item de notre flux RSS
				 console.log($(valeur).find('title').text());


			/*elementRSS = {
					titre:$(valeur).find('title').text(),
					lien:$(valeur).find('link').text(),
					datePublication:$(valeur).find('pubDate').text(),
					description:$(valeur).find('content\\:encoded').text()
			}
			stockFluxRSS.push(elementRSS);
		});
		$.each(stockFluxRSS, function(id, valeur) {
			retourHtml +='<li id="">\
				<a id ="' + id +'" class="lienContenu">\
				<p><h1 class="titre">' + valeur.titre + '</h1></p>\
				<small>'+ valeur.datePublication + '</small>\
				</a>\
				</li>';
		})
		$("#elementFluxRSS").append(retourHtml);
		$("#elementFluxRSS").listview("refresh");

		$('.lienContenu').click(function() {
			var id = parseInt($(this).attr('id'));

			$.mobile.changePage("#contenu", {
				transition: "slide"
			});
			console.log(stockFluxRSS[id].description);
			$("#contenuRSS").html('<h1 class="titre">' + stockFluxRSS[id].titre + '</h1>\
					<small>'+ stockFluxRSS[id].description +'</small>');
					}*/
		})
//
	}

	function processusKO (xml, status, xhr) {
		console.log(status);
	}
});
