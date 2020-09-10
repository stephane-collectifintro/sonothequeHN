
<?php 

	require('../../cn.php'); 
	require('../../class/sql.class.php');


    $sql = new sql();
    $sql->setQuery('SELECT * FROM chanson WHERE id_album='.$_POST['id_album'].' ORDER BY piste');
    //print $sql->getQuery();
    $sql->execute();
    
?>

<ul>

<?php while($res = $sql->result()): ?>

    <li style="line-height: 20px;"><input type="checkbox" name="track[]" value="<?php print $res['id_chanson']; ?>" /> <?php print utf8_encode($res['piste'].'. '.$res['nom']); ?></li>

<?php endwhile; ?>

</ul><br>
 <footer><input type="submit" value="Ajouter"/></footer>

