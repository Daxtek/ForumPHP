<?php
require('init-page.php');

if(!isset($_SESSION['admin']) && !($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site ) et la personne qui est connecté n'est pas un administrateur alors elle ne peut pas créer d'autres catégories
{
	header('Location: ./'); //Redirection vers la page d'accueil
}

//Initialisation des variables
$messageCreation = '';
$faute = false;


//Vérification du formulaire une fois que celui-ci est rempli
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//Récupération des données du formulaire
	if (
		isset($_POST['titre']) &&
		!empty($_POST['titre']) &&
		isset($_POST['description']) &&
		!empty($_POST['description'])
	) {

		$titre = ($_POST ['titre']);
		$description = ($_POST ['description']);
		//Récupération de l'id de l'utilisateur créateur de la catégorie
		$utilisateur_id = $_SESSION['utilisateur_id'];
		
		//Vérification de l'existence du titre
		if ($Requests->titreCategorieExist($titre))
		{
			$errorMessage .= "La catégorie que vous voulez créer existe déjà.\n";
			$faute = true;
		}	
	}
	else {
		$errorMessage .= "Les données entrées ne sont pas correctes\n";
		$faute = true;
	}
	
	//Si l'ensemble des données sont correctes on ajoute la nouvelle catégorie dans la table categorie
	if(!$faute)
	{
		//Insértion de la catégorie et ses données dans la base
		if ($Requests->addCategorie($titre, $utilisateur_id, $description))
			$messageCreation = 'La catégorie '. $titre .' à été crée !'; //Message de succées de création
		else
			$errorMessage = "Une erreur est survenue lors de l'enregistrement";
	}
}


$titlePage = 'Création Catégorie';

include 'views/template/header.php';
include 'views/creation_categorie.php';
include 'views/template/footer.php';
