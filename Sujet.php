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
	
	if (!empty( $_POST['titre']) && !empty($_POST['texte'])) // Vérifie que tous les champs du formulaire de post ont été remplis 
	{
		if(isset($_SESSION['uid'])) // Vérifie que l'utilisateur est connecté
		{
			//Variables du post à ajouter dans la BDD
			$titre=($_POST ['titre']);
			$texte=($_POST ['texte']);
			//Récupération de l'id de l'utilisateur créateur de la catégorie
			$uid = $_SESSION['uid'];
			$sid = $_GET['sid']; // l'id du sujet
			$cid = $sujet[0]['cid']; // l'id de la catégorie
			
			//Vérifications	
			for($i = 0 ; $i < count($post); $i++ ) //Parcours des titres
			{
				// Si le post existe déjà dans la BDD
				if ($post[$i]['Titre'] == $titre)
				{
					$errorMessage .= " Le post que vous voulez créer existe déjà. ";
					$faute = true;
				}
			}
			
			//Si l'ensemble des données sont correctes on ajoute le nouveau sujet dans la table sujet
			if($faute != true)
			{
				
				if ($Requests->addPost($sid, $cid, $uid, $titre, $texte)) //Si l'insertion du post s'est bien faite donc si le nouveau post existe dans la BDD
				{
					header ('Location: ./Sujet.php?sid='.$sid.''); //Réactualisation de la page
				}
				else
				{
					$errorMessage .= " Il y a eu une erreur le post n'a pas été créer, veuillez réessayer"; //Message d'erreur
				}
			}
		}
		else
		{
			$errorMessage .= " Vous devez être connecté pour poster"; //Message d'erreur
		}

		
	}

	$titlePage = $sujet[0]['Titre'];

	include 'views/template/header.php';
	include 'views/sujet.php';
	include 'views/template/footer.php';
}
else
{
	header ('Location: ./Index.php'); //Redirection vers la page d'accueil
}
