<?php

require('init-page.php');

// Récupération des catégories et des sujets
$forum = $Requests->getCategoriesAndSujets();

// ==== Formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (
		isset($_POST['pseudo']) &&
		!empty($_POST['pseudo']) &&
		isset($_POST['mdp']) &&
		!empty($_POST['mdp'])
	) {
		// Récupération des données du formulaire
		$pseudo = ($_POST['pseudo']);
		$mdp = ($_POST['mdp']);
		$user = $Requests->userConnect($pseudo, $mdp);
		// Si le pseudonyme existe déjà dans la BDD
		if ($user) {
			// Créer les variables de sessions
			$_SESSION['pseudo'] = $user['Pseudonyme'];
			$_SESSION['uid'] = $user['uid'];
			$_SESSION['admin'] = $user['Administrateur'];
			header ('Location: ./Index.php'); //Redirection vers la page d'accueil
		}
		else {
			$errorMessage .= "Vos identifiants sont faux.\n"; //Message d'erreur
		}
	}
	else
		$errorMessage .= "Vos identifiants sont faux.\n";
}

$titlePage = 'ForumPHP';

include 'views/template/header.php';
include 'views/index.php';
include 'views/template/footer.php';