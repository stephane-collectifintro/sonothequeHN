 <?php
require("init.php");
require("cn.php");
function securite_bdd($string){
        // On regarde si le type de string est un nombre entier (int)
        if(ctype_digit($string))
        {
            $string = intval($string);
        }
        // Pour tous les autres types
        else
        {
            $string = mysql_real_escape_string($string);
            $string = addcslashes($string, '%_');
        }
         
        return $string;
    }
//
if((isset($_POST['nom']) && $_POST['nom']!="")){
	$name = securite_bdd($_POST["nom"]);
	if($pdo->exec("INSERT INTO playlist SET nom_playlist='".$name."', id_utilisateur='".$_SESSION['id_utilisateur']."'")){
		echo true;	
	}else{
		echo false;	
	}
	
	
}
?>

