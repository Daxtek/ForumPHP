<?php

require('init-page.php');

require('connexion_user.php');
	

//Initialisation des variables
$messageCreation = '';
$faute = false;


if (isset( $_GET['sid'] ) && $Requests->sujetExist($_GET['sid'])) // Si l'on accède à la page via le lien du sujet dans la page d'accueil
{
	
	// Récupération du sujet
	$sujet = $Requests->getSujet($_GET['sid']);
	if ($sujet[0]['ouvert']) {
		$posts = $Requests->getPostsBySubject($_GET['sid']);

		include 'form_add_post.php';

		$titlePage = $sujet[0]['titre'];

		include 'views/template/header.php';
		include 'views/sujet.php';
		include 'views/template/footer.php';
	}
	else
		header ('Location: ./'); //Redirection vers la page d'accueil
}
else
{
	header ('Location: ./'); //Redirection vers la page d'accueil
}
