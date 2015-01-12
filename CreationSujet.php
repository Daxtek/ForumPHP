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

if (isset( $_GET['cid'] ) && !empty($_GET['cid']) ) // Si l'on accède à la page via le lien de la catégorie dans la page d'accueil
{	
	//Vérification du formulaire une fois que celui-ci est rempli
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		if (
			isset($_POST['titre']) &&
			!empty($_POST['titre']) &&
			isset($_POST['texte']) &&
			!empty($_POST['texte'])
		) {
			//Récupération des données des formulaires
			$titre=($_POST ['titre']);
			$cid = ($_GET['cid']);
			//Récupération de l'id de l'utilisateur créateur de la catégorie
			$uid = $_SESSION['uid'];
			$texte=$_POST['texte'];
			
			
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
			//Ajout du sujet
			if($Requests->addSujet($cid, $uid, $titre,$texte))
				$messageCreation = 'Le sujet '. $titre .' à été crée !'; //Message de succés
			else
				$errorMessage .= "Il y a eu une erreur le sujet n'a pas été créer, veuillez réessayer\n"; //Message d'erreur
			
		}
	}
}
else
{
	header ('Location: ./Index.php'); //Redirection vers la page d'accueil
}

$titlePage = 'Création Sujet';

include 'views/template/header.php';
include 'views/creation_sujet.php';
include 'views/template/footer.php';
