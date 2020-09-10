$(document).ready(function() {





    //lecteur audio

    function timer() {
        var current_time;
        var time = Math.round(audio.currentTime) / 60;
        minute = Math.floor(time);
        seconde = Math.round((((time - Math.floor(time)) * 60)) * 100) / 100;

        if (seconde < 10) {
            seconde = "0" + seconde;
        }
        if (minute < 10) {
            minute = "0" + minute;
        }
        if (audio.currentTime > 60) {
            current_time = minute + "\:" + seconde;
        } else {
            current_time = "00\:" + seconde;
        }

        return current_time;
    }




    $(document).on('click', '.send', function() {

        _this = $(this);
        audio_id = $('audio').attr("value");
        track = _this.parents('.track');
        id = track.attr('id');
        type = _this.parents('article.playlist').attr('type');
        playlist = _this.parents('article.playlist').attr('id');


        if ($("#playlist_rac ul").length == 0 || ($("#playlist_rac ul").attr('id') != playlist || $("#playlist_rac ul").attr('type') != type)) { // si pas de playlist chargée ou une playlist chargé mais le titre n'en fait pas parti


            track.find(".loader").fadeIn(200);

            $.ajax({
                url: '../playlist.php',
                type: 'POST',
                data: 'action=' + type + '&id_playlist=' + playlist,
                success: function(msg) {
                    $('#playlist_rac').hide().html(msg);
                    $('#playlist_rac').find("li[value=" + id + "]").click();

                }
            });

        } else { // si playlist chargée et que c'est en fait parti

            if (audio_id == id) { // si titre en cours correspond au titre selectionné

                $('#theplayer .play, #theplayer .pause').click();

            } else { // si titre en cours ne correspond pas au titre selectionné

                $('#playlist_rac').find("li[value=" + id + "]").click();
                track.find(".loader").fadeIn(200);


            }

        }




    });

    $(document).on('click', '.album-send', function() {

        _this = $(this);
        audio_id = $('audio').attr("value");
        track = _this.parents('.playlist').find('.track').first();

        id = track.attr('id');
        type = _this.parents('article.playlist').attr('type');
        playlist = _this.parents('article.playlist').attr('id');


        if ($("#playlist_rac ul").length == 0 || ($("#playlist_rac ul").attr('id') != playlist || $("#playlist_rac ul").attr('type') != type)) { // si pas de playlist chargée ou une playlist chargé mais ce n'est pas celle selectionnée

            track.find('.send').click();

        } else {


            $('#theplayer .play, #theplayer .pause').click();

        }


    });

});
//



//audio
function loadSong(elt) {
    var item = jQuery(elt); //on recupere la ligne

    $("li.selected_music").removeClass("selected_music");
    item.attr('class', 'selected_music');

    //$("#player").attr('src',elt.id+'.mp3');
    $("#player").currentTime = 0;
    $("#player").attr('src', elt.id);
    $("#player").attr('value', elt.value);
    return false;
}
