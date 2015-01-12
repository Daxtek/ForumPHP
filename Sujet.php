<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->
<?php

require('init-page.php');

require('ConnexionUser.php');
	

//Initialisation des variables
$messageCreation = '';
$faute = false;


if (isset( $_GET['sid'] )) // Si l'on accède à la page via le lien du sujet dans la page d'accueil
{
	
	// Récupération du sujet
	$sujet = $Requests->getSujet($_GET['sid']);
	$post = $Requests->getPostsBySubject($_GET['sid']);

	include 'formAddPost.php';

	$titlePage = $sujet[0]['Titre'];

	include 'views/template/header.php';
	include 'views/sujet.php';
	include 'views/template/footer.php';
}
else
{
	header ('Location: ./Index.php'); //Redirection vers la page d'accueil
}
