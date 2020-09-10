
<footer id="theplayer">

  <div class="player">

    <div class="actions">

      <div class="infos">
        <div class="infos_plus"> <b>+</b> </div>
        <div class="infos_img"> <img src="img/img-lb.jpg" width="41" height="41" /> </div>
        <div class="infos_title"><br/>
          <span class="aniLight"></span> </div>
        <div class="clear"></div>
      </div>


      <div class="before"></div>
      <div class="play" ></div>
      <div class="next"></div>
      <div class="clear"></div>
    </div>



    <div class="progress">

    	<audio  id="player"  autoplay="autoplay" preload="auto" autobuffer type='audio/<?php print $file_format; ?>'>Votre navigateur n'accepte pas les mp3 </audio>

    	<div class="current_time"></div>

      	<div class="barre">
        	<div class="buffer" style="height:50px"></div>
        	<div class="pointer"><img src="img/pointer.svg" width="15" /></div>
      	</div>

        <div class="durring_time"></div>
        <input id="vol-control" type="range" min="0" max="100" step="1" oninput="SetVolume(this.value)" onchange="SetVolume(this.value)"></input>
        <script>
          function SetVolume(val)
          {
              var player = document.getElementById('player');
              console.log('Before: ' + player.volume);
              player.volume = val / 100;
              console.log('After: ' + player.volume);
          }
        </script>
    </div>



    <div class="playlist">
    	<div id="playlist_rac" class="ico_infos list_album"></div>
      <div class="icoPlaylist"><i class="glyphicon glyphicon-list"></i></div>
    </div>
    <div class="clear"></div>
  </div>
</footer>
