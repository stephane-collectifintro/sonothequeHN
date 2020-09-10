<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script>
	$(function(){



		$("#merge").hide();

		$("#oui").click(function(){
			$("#choice").slideUp(200);
			$("#merge").slideDown(200);
		});

		$("#merge").submit(function(){


			dataform = $(this).serialize();

			$.ajax({ 
				type: "POST", 
				url: "account.php", 
				data: dataform+"&action=merge&nom=<?php print $lastname; ?>&prenom=<?php print $firstname; ?>&mail=<?php print $email; ?>&fid=<?php print $fid; ?>&city=<?php print $city; ?>", 
				success: function(msg){ 

					if(msg==="true"){

						$('#merge').html('<div class="alert alert-success text-center" role="alert">Succès !</div>');
						setTimeout(function(){
							window.location.href="<?php print $origin; ?>";
						},3000);
					
					}else{

						$('#merge').append('<div class="alert alert-danger" role="alert">Identifiant ou mot de passe incorrect !</div>');

					}

				},
				error: function(msg){ 
					$('#merge').append('<div class="alert alert-danger" role="alert">Une erreur s\'est produite ! veuillez réessayer ultérieurement.</div>');
	
				}

			});

			return false;

		});

		$("#non").click(function(){
			$("#choice").slideUp(200);

			$.ajax({ 
				type: "POST", 
				url: "account.php", 
				data: "action=add&nom=<?php print $lastname; ?>&prenom=<?php print $firstname; ?>&mail=<?php print $email; ?>&fid=<?php print $fid; ?>&city=<?php print $city; ?>", 
				success: function(msg){ 

					if(msg==="true"){

						$('#assoc_new').html('<div class="alert alert-success text-center" role="alert">Succès ! Nouveau compte crée !</div>');
						setTimeout(function(){
							window.location.href="<?php print $origin; ?>";
						},3000);
					
					}else{

						$('#assoc_new').append('<div class="alert alert-danger" role="alert">Une erreur s\'est produite ! veuillez réessyer ultérieurement.</div>');

					}

				},
				error: function(msg){ 
					$('#assoc_new').append('<div class="alert alert-danger" role="alert">Une erreur s\'est produite ! veuillez réessayer ultérieurement.</div>');
				}

			});

		});

	});
	</script>
	<style>
	.alert{
		margin:15px;
	}
	</style>

</head>
<body>

<div class="container well" id="assoc_new">

	<img src="../img/logo.svg" class="center-block" style="margin-top:-30px;">
	
	<div class="page-header">
	  <h1 text>Possédiez-vous déjà un compte sur la Sonothèque Normandie ?</h1>
	  <br>
	  <p class="help-block">Vous avez la possibilité de relier votre compte facebook à votre compte Sonothèque déjà existant, pour cela, répondez "oui" à la question puis entrez vos identifiants habituels.<br>Cette opération ne vous sera demandé qu'une seule fois. </p>
		<br>
	  <div class="text-center" id="choice"><button class="btn btn-primary" id="oui"><i class="glyphicon glyphicon-ok-sign"></i> oui, j'ai déjà un compte sonotèque</button> <button class="btn btn-default" id="non"><i class="glyphicon glyphicon-remove-sign"></i> non, je n'ai pas de compte Sonothèque</button></div>
		<br>
	</div>

	

	<form id="merge" class="container col-md-6 col-md-offset-3">
	  <div class="form-group">
	    <label for="exampleInputEmail1">Identifiant</label>
	    <input type="email" name="login" class="form-control" id="exampleInputEmail1" placeholder="Entrez l'adresse email associée à votre compte Sonothèque" required>
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Mot de passe</label>
	    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Entrez le mot de passe associé à votre compte Sonothèque" required>
	  </div>
	 
	  <button type="submit" class="btn btn-success center-block"> <i class="glyphicon glyphicon-ok"></i> Associer</button>
	</form>
	
</div>
</body>
</html>