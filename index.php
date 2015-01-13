<?php

require('init-page.php');

//Initialisation des variables
$messageFermeture = '';

//Test si on est déjà connecté
require('connexion_user.php');

// Récupération des catégories et des sujets
$forum = $Requests->getCategoriesAndSujets();

// Vérification du formulaire de fermeture de sujet une fois que celui-ci est rempli
if (isset ($_POST ['SujetAFermeID']) && !empty ( $_POST ['SujetAFermeID'] )) 	
{
	if($Requests->closeSubject($_POST ['SujetAFermeID']))
	{
		header('Location: ./'); //Réactualise la page
	}
	else
	{
		$errorMessage.= 'Le sujet n\'a pas été fermé, il y a eu un problème';
	}
}
// Vérification du formulaire d'ouverture de sujet une fois que celui-ci est rempli
if (isset ($_POST ['SujetAReouvrirID']) && !empty ( $_POST ['SujetAReouvrirID'] ))
{
	if($Requests->openSubject($_POST['SujetAReouvrirID']))
	{
		header('Location: ./'); //Réactualise la page
	}
	else
	{
		$errorMessage.= 'Le sujet n\'a pas été réouvert';
	}
}

$titlePage = 'ForumPHP';

include 'views/template/header.php';
include 'views/index.php';
include 'views/template/footer.php';


