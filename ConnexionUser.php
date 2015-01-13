<?php

// ==== Formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//Test si le pseudonyme et le mot de passe sont déjà défini
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
		$_SESSION['pseudo'] = $user['pseudo'];
		$_SESSION['uid'] = $user['utilisateur_id'];
		$_SESSION['admin'] = $user['admin'];
		if (isset($_GET['sid'])) //Si on est sur la page de sujet
		{
			header ('Location: ./Sujet.php?sid='.$_GET['sid'].''); //Redirection vers la page du sujet où on est
		}
		else
		{
			header ('Location: ./Index.php'); //Redirection vers la page d'accueil
		}		
	}
	else {
		$errorMessage .= "Vos identifiants sont faux.\n"; //Message d'erreur
		}
	}
}

?>