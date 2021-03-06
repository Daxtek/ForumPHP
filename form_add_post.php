<?php

if ( // Vérifie que tous les champs du formulaire de post ont été remplis
	$_SERVER['REQUEST_METHOD'] == 'POST' &&
	isset($_POST['texte']) &&
	!empty($_POST['texte'])
) {

	if(isset($_SESSION['utilisateur_id'])) // Vérifie que l'utilisateur est connecté
	{
		//Variables du post à ajouter dans la BDD
		$texte=($_POST ['texte']);
		//Récupération de l'id de l'utilisateur créateur de la catégorie
		$utilisateur_id = $_SESSION['utilisateur_id'];
		$sujet_id = $_GET['sid']; // l'id du sujet
		
		//Si l'ensemble des données sont correctes on ajoute le nouveau sujet dans la table sujet
		if(!$faute)
		{
			if ($Requests->addPost($sujet_id, $utilisateur_id, $texte)) //Si l'insertion du post s'est bien faite donc si le nouveau post existe dans la BDD
				header ('Location: ./sujet.php?sid='.$sujet_id.''); //Réactualisation de la page
			else
				$errorMessage .= " Il y a eu une erreur le post n'a pas été enregistré, veuillez réessayer"; //Message d'erreur
		}
	}
	else
	{
		$errorMessage .= " Vous devez être connecté pour poster"; //Message d'erreur
	}
}