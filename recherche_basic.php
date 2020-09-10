<div id="entete" class="content-center">
  
  <div class="allSearch">
    <div class="search">
    <form id="recherche">
      <input type="search" name="search" placeholder="Rechercher un titre, un album, un artiste...">
      <input type="hidden" name="action" value="all">
    	<div class="loupe"> </div>
      </form>
    </div>
    <div class="searchPlus">
      <div class="loupe2"> </div>
      <header> recherche avancée </header>
    </div>
    <?php include('recherche_avancee.php'); ?>
    <div class="clearfix"></div>
  </div>

  <?php require_once('header_profile.php'); ?>

  
</div>
