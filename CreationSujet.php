<?php

require('init-page.php');

if(!isset($_SESSION['uid'])) //Si la variable de session n'a pas été créer ( si la personne n'est pas connectée au site )
{
	header('Location: ./Index.php'); //Redirection vers la page d'accueil
}

//Initialisation des variables
$messageCreation = '';
$faute = false;
$nouveauSujet = false; // Boolean de vérification de la création du nouveau sujet

// Récupération des catégories pour le ménu déroulant dans le form
$categories = $Requests->getAllCategories();

//Vérification du formulaire une fois que celui-ci est rempli
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (
		isset($_POST['titre']) &&
		!empty($_POST['titre']) &&
		isset($_POST['description']) &&
		!empty($_POST['description']) &&
		isset($_POST['categorie']) &&
		!empty($_POST['categorie'])
	) {
		//Récupération des données du formulaire
		$titre=($_POST ['titre']);
		$description=( $_POST ['description']);
		$cid = ($_POST['categorie']);
		//Récupération de l'id de l'utilisateur créateur de la catégorie
		$uid = $_SESSION['uid'];
		
		// Si le titre existe déjà dans la BDD
		if ($Requests->titreSujetExist($titre, $cid))
		{
			$errorMessage .= "Le sujet que vous voulez créer existe déjà.\n";
			$faute = true;
		}
		
		//Vérifivation qu'une catégorie à bien été choisie
		if($cid < 0) {
			$errorMessage .= "Veuillez séléctionner une catégorie.\n";
			$faute = true;
		}

		//Vérification de l'existence de la catégorie
		if (!$Requests->categorieExist($cid)) {
			$errorMessage .= "La catégorie n'existe pas.\n";
			$faute = true;
		}
	}
	else {
		$errorMessage .= "Les données entrées ne sont pas correctes\n";
		$faute = true;
	}

	//Si l'ensemble des données sont correctes on ajoute le nouveau sujet dans la table sujet
	if (!$faute)
	{
		if ($Requests->addSujet($cid, $uid, $description, $titre)) //Si le nouveau sujet existe dans la BDD 
			$messageCreation = 'Le sujet '. $titre .' à été crée !'; //Message de succés
		else 
			$errorMessage .= "Il y a eu une erreur le sujet n'a pas été créer, veuillez réessayer\n"; //Message d'erreur
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title> Création sujet</title>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top"><!-- Barre de navigation principal -->
		     <div class="container">
		     	<div class="navbar-header">
		        	<a class="navbar-brand" href="Index.php">Forum PHP</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
					<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
		        </div>
		   	</div>
	    </nav>
	    <section class="container"> <!-- Section central -->
		<header>
			<h1> Formulaire de création de sujet</h1>
		</header>
		<form  name="formSujet" action="#" method="POST" onsubmit="return verifForm()">
			<label  for="idtitre"> Titre : </label><input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required ><br>
			<label  for="iddescrip"> Description : </label><textarea class="form-control"  id="iddescrip" name="description" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
			<label  for="iddescrip"> Catégorie : </label>
			<select class="form-control" name="categorie">
				<option value="select"> Sélectionnez la catégorie à laquelle le sujet appartient </option>  <!-- Affiche les différents choix possible à l'aide d'une boucle  -->
				<?php foreach ($categories as $key => $categorie): ?>
					<option value=<?= $categorie['cid']?>><?=  $categorie['Titre'] ?> </option> 
				 <?php endforeach ?>
			</select>
			<br>
			
			<input class="btn btn-default" type="submit" value="Valider">
			<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
		</form>
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
	titre = document.formSujet.titre.value;
	
	var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(titre)) 
	{	
		alert("le titre n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}