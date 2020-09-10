<?php session_start(); ?>
<?php
require('../cn.php');
//

if(isset($_POST['login']) && isset($_POST['password'])){
	//
	$login = $_POST['login'];
	$password = $_POST['password'];
	//
	/*$sql = "SELECT * FROM user WHERE login_user='".$login."' AND password_user='".md5($password)."' LIMIT 1";
	$req = mysql_query($sql);
	$res = mysql_fetch_array($req);*/


	//

	$sql = $pdo->query("SELECT * FROM user WHERE login_user='".$login."' AND password_user='".md5($password)."' LIMIT 1");

	
	if($res = $sql->fetch(PDO::FETCH_OBJ)){
		$_SESSION['user']['id']=$res['id_user'];
		$_SESSION['user']['login']=$res['login_user'];
		echo "<script>window.location.href='liste_actualite.php';</script>";
	}else{
		
		echo 'Identification incorrecte';
	}
		
}
//


//$req = mysql_query($sql);
//
?>


<div id="content">



<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" >
<article style="width:60%; text-align:center; margin:100px auto 50px auto;">
	<header>Connexion</header>
	<span class="champs">
		<strong>Identifiant</strong>
		<input type="text" name="login">
    </span>
    <span class="champs">
		<strong>Mot de passe</strong>
		<input type="password" name="password">
    </span>
    
    
    <footer><input type="submit" value="connexion"></footer>
    
</article>

</form>
</div>