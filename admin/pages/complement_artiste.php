<?php

?>
<div id="content">
<div class="titre">complement artiste</div>	
	<?php 
	//
	$sql = new sql();
	$sql->select('complement_artiste',"id_complement_artiste='".$id."'");
	$sql->execute();
	$res = $sql->result();
	//
	$mail = utf8_encode($res['mail_complement_artiste']);
	$texte = utf8_encode($res['texte_complement_artiste']);
	//
	?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data"> 
    <article>
        <header>
        </header>
        
        <span class='champs'><strong>Suggeré par :</strong><br /><input type="text" name="mail" value="<?php echo $mail;  ?>" /></span>
        
        <span class='champs'><strong>Complément :</strong><br /><textarea name="description"><?php echo $texte; ?></textarea></span>
        
    </article>
    </form>
</div>