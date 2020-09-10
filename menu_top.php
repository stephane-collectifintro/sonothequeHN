<header id="header_page">
    	<div class="content-center">
           <!-- NAVBAR -->
            <nav id="navbar">
                <div class="content-center">
                    <ul class="left">
                        <li class="active" ><a href="artistes.php" title="Liste des artistes de la Sonotheque">artistes</a></li>
                        <li><a href="infos.php" title="Le projet - Qui sommes-nous">le projet</a></li>
                        <li><a href="contact.php" title="Contactez-nous">contacts</a></li>
                    </ul>
                    <div class="connect right" id="connect">
                      
                      <?php
                      if(isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur']!=""):

                        include('view/login.php');

                      else:
                      
                        include('view/logout.php');  
                      
                      endif;
                      ?>
                    </div>
                    <div class="clearfix"></div>
                </div> 
            </nav>
            <div class="logo">
       	    	<a href="home.php" title="La Sonotheque Normandie - Site d'&eacute;coute gratuite d'artiste de Normandie"><img src="img/logo.svg" width="209" height="144"> </a>
            </div>
         </div>
      </header>