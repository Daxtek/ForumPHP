
<?php

require('init-page.php');

if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
{
	if(($_SESSION['admin']) == '0') //Si la personne qui est connecté n'est pas un administrateur alors elle ne peut pas créer d'autres comptes
	{
		header('Location: ./Index.php'); //Redirection vers la page d'accueil
	}
}

//Initialisation des variables
$messageInscription ='';
$faute = false;

//Vérification du formulaire une fois que celui-ci est rempli
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (
		isset($_POST['nom']) &&
		!empty( $_POST['nom']) &&
		isset($_POST['prenom']) &&
		!empty( $_POST['prenom']) &&
		isset($_POST['email']) &&
		!empty( $_POST['email']) &&
		isset($_POST['pseudo']) &&
		!empty( $_POST['pseudo']) &&
		isset($_POST['mdp']) &&
		!empty( $_POST['mdp']) &&
		isset($_POST['mdpConfirmation']) &&
		!empty( $_POST['mdpConfirmation'])
	) { // Uniquement $nom car tous les champs sont requis ( required ) 

		//Récupération des données du formulaire
		$nom=($_POST ['nom']);
		$prenom=( $_POST ['prenom']);
		$mail=( $_POST ['email']);
		$pseudo=( $_POST ['pseudo']);
		$mdp=( $_POST ['mdp']);
		$mdpConfirmation=( $_POST ['mdpConfirmation']);
	
	//Vérification de l'existence du pseudonyme
		if ($Requests->userExist($pseudo)) {
			$errorMessage .= "Le pseudonyme que vous avez choisi existe déjà.\n"; // message d'erreur
			$faute = true;
		}

		
	//Vérification de l'existence du mail
		if ($Requests->mailExist($mail))
		{
			$errorMessage .= "Le mail que vous avez choisi existe déjà.\n";
			$faute = true;
		}
		
	//Vérification du mot de passe	
		if ( $mdp != $mdpConfirmation)
		{
			$errorMessage .= "Les mots de passe ne correspondent pas.\n";
			$faute=true;
		}		
		
	//Si l'ensemble des données sont correctes on ajoute le nouveau membre dans la table utilisateur
		if(!$faute)
		{
			//Insertion des données de l'utilisateur dans la base
			if ($Requests->addUser($pseudo, $mdp, $mail, $nom, $prenom)) {
				//Personnalisation du message en fonction de si l'utilisateur est un administrateur ou non
				if(isset($_SESSION['admin']))
					$messageInscription ='Vous avez inscrit l\'utilisateur ' . $pseudo  ;
				else
					$messageInscription ='Vous êtes inscrit '. $pseudo;
			}

			else
				$errorMessage .= "Une erreur est survenu lors de l'enregistrement...";
		}
	} 
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title> Page d'incscription</title>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top"><!-- Barre de navigation principal -->
		     <div class="container">
		     	<div class="navbar-header">
		        	<a class="navbar-brand" href="Index.php">Forum PHP</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		        	<?php if(isset($_SESSION['admin'])):?><!--  Si la variable de session a été créer ( si la personne est connectée au site ) -->
						<?php if(($_SESSION['admin']) == '1') :?>
							<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
						<?php endif;?>
		        	<?php endif;?>
		        </div>
		   	</div>
	    </nav>
	    <section class="container"> <!-- Section central -->
			<header>
				<h1> Formulaire d'inscription</h1>
			</header>
			<form name="formInscription" action="#" method="POST" onsubmit="return verifForm()">
				
				<label for="idnom"> Nom : </label><input class="form-control" type="text" id="idnom" name="nom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un nom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
				<label for="idprenom"> Prénom : </label><input class="form-control" type="text" id="idprenom" name="prenom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un prénom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
				<label for="idemail"> Email : </label><input class="form-control" type="email" id="idemail" name="email" maxlength="100" pattern="[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}" title="Veuillez rentrez un email valide" required ><br>
				<label for="idmdp"> Mot de passe : </label><input class="form-control" type="password" id="idmdp" name="mdp" required ><br>
				<label for="idmdpConfirmation"> Confirmer le mot de passe : </label><input class="form-control" type="password"  id="idmdpConfirmation" name="mdpConfirmation" required title="Les deux champs doivent correspondre" ><br>
				<label for="idpseudo"> Pseudonyme : </label><input class="form-control" type="text" id="idpseudo" name="pseudo" size="20" maxlength="20" required pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789]{2,}" title="Le pseudonyme peut contenir des chiffres et des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" ><br>
				
				<input class="btn btn-default" type="submit" value="Valider">
				<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
			</form>
		<!-- Messages d'alerte -->
		<?php if(!empty($errorMessage)):?> <!-- Rencontre-t-on une erreur ?  -->
				<p class="alert alert-danger"> <?= htmlspecialchars($errorMessage) ?> </p>
		<?php elseif(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
			<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
		<?php endif;?>
		</section>
		<footer class="container">
			<!-- Pied de page avec le lien vers l'accueil -->
			<a class="btn btn-primary navbar-btn" href="Index.php"> Retour </a>
		</footer>
	</body>
</html>
<script>
	
/* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
function verifForm()
{
	nom = document.formInscription.nom.value;
	prenom = document.formInscription.prenom.value;
	mail = document.formInscription.email.value;
	pseudo = document.formInscription.pseudo.value;
	
	var reg = new RegExp("^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(nom)) 
	{	
		alert("le nom n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}

	if (!reg.test(prenom)) 
	{	
		alert("le prenom n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
	var reg = new RegExp("^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(pseudo)) 
	{	
		alert("le pseudo n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}

	var reg = new RegExp("^[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}$"); /* Ici on doit ajouter un + avant le @ car on a pas defini la taille de la zone ! */
	if (!reg.test(mail)) 
	{
		alert("le mail n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}	
</script>




