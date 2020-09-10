<?php
require('session.php');
require('../cn.php');
require('../class/media.class.php');
require('../class/sql.class.php');
require('../class/texte.class.php');
require('../class/videoPlatform.class.php');
require_once('../class/getid3/getid3.php');
require_once("../fonctions/fonctions.php");
//
$page=$_GET['page'];
$id = $_GET['id'];
$_SESSION['page']=$page;
$_SESSION['id']=$id;
//
//
function menu_on($value,$array){
	if(in_array($value, $array)){
		echo "class='on'";
	}
}
//
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Administration - <?php echo $page; ?></title>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="../js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../js/tiny_mce/tiny_mce.js',
			theme_advanced_default_background_color : "#FFF",
			// General options
			theme : "advanced",
			//plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			// Style formats
			/*style_formats : [
					{title : 'Important', inline : 'b'},
					{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
					{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
					{title : 'Example 1', inline : 'span', classes : 'example1'},
					{title : 'Example 2', inline : 'span', classes : 'example2'},
					{title : 'Table styles'},
					{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}

			],*/
			style_formats : [
					{title : 'soustitre', inline : 'span', classes : 'soustitre'},
					{title : 'designation', inline : 'span', classes : 'designation'},
					{title : 'important', inline : 'span', classes : 'important'},

			],
			/*style_formats : [
					{title : 'Important', inline : 'b'},
					{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
					{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
					{title : 'Example 1', inline : 'span', classes : 'exemple1'},
					{title : 'Example 2', inline : 'span', classes : 'example2'},
					{title : 'Table styles'},
					{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}

			],*/

			theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect,|,forecolor,backcolor,|,link,unlink,|",

			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			// Example content CSS (should be your site CSS)
			//content_css : "styles.css",
			force_br_newlines : true,
			force_p_newlines : false,
			forced_root_block : ''

		});


		$( ".column" ).sortable({

			handle: ".move",
			update: function() {  // callback quand l'ordre de la liste est changé

				var order = $('.column').sortable('serialize'); // récupération des données à envoyer

				$.ajax({
			       url : 'views/get_order.php',
			       type : 'POST',
			       data : 'id_radio=<?php print $_GET["id"] ?>&'+ order,
			       success : function(msg){ // code_html contient le HTML renvoyé

			          //alert(msg);
			       }
			    });
			}

	    });


	    $(".media .photo .inner img").draggable({

			axis: "y",

			drag: function() {

				$(this).parent().css("overflow","visible");

			},

			stop: function(){

				$(this).parent().css("overflow","hidden");

				t = $(this).css("top").replace('px','');
				h = $(this).css("height").replace('px','');
				hc = $(this).parent().css('padding-top').replace('px','');
				e = hc-h;


				if(t>0){
					$(this).css("top","0");
				}

				if(t<e){
					$(this).css("top",e);
				}

				t = $(this).css("top").replace('px','');
				hc = $(this).parent().css('padding-top').replace('px','');
				e = h-hc;

				pct = (t/hc)*100;



				id = $(this).attr("data-id-photo");

	   			$.ajax({
			       url : 'views/get_align_photo.php',
			       type : 'POST',
			       data : 'id=' + id + '&pct='+ pct,
			       success : function(msg){

			       }
			    });
	   		}
		});
	});
</script>
<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/cropper.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link  href="css/cropper.min.css" rel="stylesheet">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="global">
<?php if($page=='connexion'){ ?><div style="margin:0 auto; width:960px;"><?php }else{ ?><div id="global"><?php } ?>
	<?php if($page!='connexion'){ ?>
    <nav style="position:relative;">
        <ul>
        	<?php
			$sql = new sql();
			$sql->select("admin_page","","*","ORDER BY order_admin_page");
			$sql->execute();
			while($res=$sql->result()){
				$$res['nom_admin_page'] = array('liste_'.$res['nom_admin_page'],$res['nom_admin_page'],'ajout_'.$res['nom_admin_page']);
			?>
        	<li <?php menu_on($page,$$res['nom_admin_page']); ?>><a href="liste_<?php echo $res['nom_admin_page'] ?>.php"><?php echo utf8_encode($res['titre_admin_page']); ?></a></li>

            <?php } ?>
            <br><br>

            <li style="line-height:30px;"><a href="deconnexion.php">Déconnexion</a></li>
        </ul>

    </nav>
    <?php } ?>
    <div id="main"<?php if($page=='connexion'){ echo " style='width:100%;' "; } ?> >
    	<?php
			include("pages/".$page.".php");
		?>
    </div>
    <div class="clear">
</div>
</body>
</html>
