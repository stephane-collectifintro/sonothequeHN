

<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest") {
	//Si on est en Ajax ?>

    <?php
}else{?>

  </div> <!-- fin column 2-->

  <div class="column col3">
   	<?php require_once('sidebar_right.php'); ?>
  </div>
  <div class="clearfix"></div>

</div> <!-- fin .content-center -->

</section> 	<!-- section#content -->

<?php require_once('player.php'); ?>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39976701-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="https://sonotheque-normandie.com/js/cookiechoices.js"></script><script>document.addEventListener('DOMContentLoaded', function(event){cookieChoices.showCookieConsentBar('Ce site utilise des cookies pour vous offrir le meilleur service. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.', 'J’accepte', 'En savoir plus', 'https://sonotheque-normandie.com/infos.phphttp://www.example.com/mentions-legales/');});</script>      
</body></html><?php } ?>
