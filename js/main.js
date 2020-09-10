function init_items() {
    $('#chargement').hide();
    $("#recherche_avance").hide();
    $("#menu").hide('fast');
    $(".loader").hide();
    $('.artisteAlbum').hide();
    $(".infos").hide();

    $(".sortable").sortable({
        axis: "y",
        handle: ".sort",
        update: function() {  // callback quand l'ordre de la liste est changé
                
            var list = [];
            $(this).find('.track').each(function(){
               list.push("order[]="+$(this).attr("data-id"));
            });
            order = list.join('&');
            playlist = $(this).attr('data-playlist');
            $.ajax({
                url : 'order_playlist.php',
                type : 'GET',
                data : 'playlist=' + playlist + '&'+ order,
                success : function(msg){ // code_html contient le HTML renvoyé

                    /*alert(msg);*/
    
                }
            });
        }
    });
    $('.diapo').cycle({ 
        slides : ">img"
    });

    if($(".crop").height() >= $(".crop .content").height()){
        $(".arrow-bottom").remove();
        $(".crop").height($(".crop .content").height());
        $(".crop .gradient").remove();
    }
}


function init() {

    init_items();
	

    $(".various").fancybox({
        maxWidth: 600,
        maxHeight: 480,
        fitToView: false,
        width: '70%',
        height: '70%',
        autoSize: false,
        closeClick: false,
        openEffect: 'fade',
        closeEffect: 'fade',
        scrolling: 'no',
        preload: true
    });



    $(".add").fancybox({
        maxWidth: 600,
        maxHeight: 165,
        fitToView: false,
        width: '70%',
        height: '70%',
        closeBtn: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'fade',
        closeEffect: 'fade',
        scrolling: 'no',
        preload: true
    });


    $(".share").fancybox({
        
        fitToView: false,
        width: '400',
        height: '160',
        closeBtn: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'fade',
        closeEffect: 'fade',
        scrolling: 'no',
        preload: true
    });


    $(document).on('click', '.plusmoinsinfos', function() {

        if ($(this).parent().find('.artisteAlbum').is(':hidden')) {

            $(this).html('<i class="moins">');

        } else {

            $(this).html('<i class="plus">');
        }

        $(this).parent().find('.artisteAlbum').slideToggle(250);

    });



    // RECHERCHE ET RECHERCHE AVANCEE 


    $(".searchPlus").click(function() {
        $("#recherche_avance").slideToggle(250);
    });


    $("#go").click(function() {
        var selection = '';

        var selection = $("#recherche_avance form").serialize();

        load_content('recherche', 'recherche.php?' + selection);

    });

    $(".loupe").click(function() {

        $(this).find('input').blur();
        $("#autocomplete").remove();

        var selection = $("form#recherche").serialize();
        load_content('recherche', 'recherche.php?' + selection);
    });

    $("#recherche").submit(function() {

        $(this).find('input').blur();
        $("#autocomplete").remove();

        var selection = $("form#recherche").serialize();
        load_content('recherche', 'recherche.php?' + selection);

        return false;
    });







    // AUTO COMPLETE


    function autocomplete() {
        $("#recherche_avance").hide();
        val = $(this).val();
        count = $(this).val().length;
        min = 1;



        if (val != "") {

            if (!$("#autocomplete").length) {

                $(this).parents(".search").append('<div id="autocomplete"></div>');

            }

            if (count >= min) {

                $("#autocomplete").html("");

                $.ajax({

                    type: "POST",
                    url: "autocomplete.php",
                    data: "search=" + val,
                    success: function(msg) {

                        $("#autocomplete").html(msg);

                    },
                    error: function(msg) {

                    }

                });

            } else {

                $("#autocomplete").html("Veuillez entrer " + min + " caractères minimum !");

            }





        } else {

            $("#autocomplete").remove();

        }

    }


    $('#recherche input').on('keyup', autocomplete);
    $('#recherche input').on('focus', autocomplete);

    $(document).on("click", "#autocomplete a", function() {
        $("#autocomplete").remove();
    });


    $("body").on('click', function() {

        if (!$(".search").is(":hover")) {
            $("#autocomplete").remove();
        }

    });




    $(document).on("click", "article.playlist[type='playlist'] .information h2", function() {

        $(this).hide();
        $("#modif_playlist_form").show().find("input").select();
        
    });

    $(document).on("click", ".modif-playlist", function() {

      
        _this = $(this);
        id = _this.attr('data-id');
        titre = _this.siblings('input').val();

        
        if(titre!="" && titre!=$("section.information h2").text()){

            $.ajax({
                url: 'modif_playlist.php',
                type: 'POST',
                data : { pid: id, ptitre: titre },
                success: function(msg) {

                    if (msg == true) {
                     
                        _this.parent().hide().siblings("h2").text(titre).show()
                        $(".page-header h1 span").text(titre);
                        
                    } else {

                        alert("Une erreur s'est produite, veuillez r\351essayer ult\351rieurement");
                    
                    }
                }
            });

        }else{

            $(this).parent().hide().siblings("h2").show();

        }
        
    });





    $(document).on("click", ".suppr-playlist", function() {

       if(confirm("Êtes vous sûr de vouloir supprimer cette playlist ?")){
            _this = $(this);
            id = _this.attr('data-id');

            $.ajax({
                url: 'suppr_playlist.php',
                type: 'POST',
                data: 'id=' + id,
                success: function(msg) {

                    if (msg == true) {
                     
                        $("#link_playlists").click();
                        
                    } else {

                        alert("Une erreur s'est produite, veuillez r\351essayer ult\351rieurement");
                    
                    }
                }
            });
        }
    });




    $(document).on("click", "i.like", function() {

        _this = $(this);

        type = _this.attr('data-type');
        id = _this.attr('data-id');
        action = _this.attr('data-action');


        $.ajax({
            url: 'view/like.php',
            type: 'POST',
            data: 'type=' + type + '&id=' + id + '&action=' + action,
            success: function(msg) {

                if (msg == "done") {

                    if (action == "add") {

                        _this.addClass('on').attr('data-action', 'remove')

                    } else {

                        _this.removeClass('on').attr('data-action', 'add');
                    }

                } else {
                    alert("Une erreur s'est produite, veuillez r\351essayer ult\351rieurement");
                }
            }
        });
    });


    $(document).on("click", "i.suppr", function() {

       if(confirm("Êtes vous sûr de vouloir supprimer ceci ?")){
            _this = $(this);

            id = _this.attr('data-id');
            playlist = _this.attr('data-playlist');

            $.ajax({
                url: 'suppr_playlist_titre.php',
                type: 'POST',
                data: 'id=' + id +'&playlist=' + playlist,
                success: function(msg) {

                    if (msg == "done") {
                     
                        _this.parents("li.track").remove();
                        
                    } else {

                        alert("Une erreur s'est produite, veuillez r\351essayer ult\351rieurement");
                    
                    }
                }
            });
        }
    });


    $(document).on("change", ".cmn-toggle", function() {

        _this = $(this);

       publique = $(this).is(":checked");
       playlist = $(this).val();

       $.ajax({
            url: 'playlist_public.php',
            type: 'POST',
            data: 'publique=' + publique +'&playlist=' + playlist,
            success: function(msg) {

                if(publique==false){
                    _this.parents('.information').find(".share").hide(400);
                    _this.siblings('span').text("Privé");    
                }else{
                    _this.parents('.information').find(".share").show(400);
                    _this.siblings('span').text("Public");
                }
                

                
            }
        });

    });




    $(document).on("submit", "#profile_image", function(e) {


       
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();

        $.ajax({
            url: 'modif_profil_image.php',
            type: 'POST',
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            data: data,
            success: function(msg) {

                if (msg!="" && msg!=false) {

                    $form[0].reset();
                    $form.find('img.img-circle').css({"background-image":"url("+msg+")"});
                    $('#header-profil-image').css({"background-image":"url("+msg+")"});

                }else{


                }
                

                
            }
        });
        return false;

    });
    

    $(document).on("click",".arrow-bottom",function(){
      
        $this = $(this);
          
        if($(".crop").height() < $( ".crop .content" ).height() ){

            $(".crop").animate({
              height: $( ".crop .content" ).height()
            }, 400, function() {
              $this.addClass("arrow-top");
            });
            $(".crop .gradient").hide(400);

        }else{

            $(".crop").animate({
              height: "100px"
            }, 400, function() {
              $this.removeClass("arrow-top");
            });
            $(".crop .gradient").show(400);

        }
    });







}

$(document).ready(init);
