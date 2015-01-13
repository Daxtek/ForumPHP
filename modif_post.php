<?php 

require('init-page.php');
$faute = false;

if (isset( $_GET['pid'] ) && $Requests->postExist($_GET['pid'])) { // Si l'on accède à la page via le lien du sujet dans la page d'accueil
	$post_id = $_GET['pid'];
	$post = $Requests->getPost($post_id);

	if ($_SESSION['utilisateur_id'] == $post['utilisateur_id'] || $_SESSION['admin']) {
		// Gestion du formulaire
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (
				isset($_POST['texte']) &&
				!empty($_POST['texte'])
			) {

				// Variables du post à ajouter dans la BDD
				$texte = $_POST['texte'];

				if ($Requests->updatePost($post_id, $texte)) // Update du post
					header ('Location: ./sujet.php?sid='.$post['sujet_id'].''); // Retour vers le sujet
				else
					$errorMessage .= " Il y a eu une erreur le post n'a pas été enregistré, veuillez réessayer";	
			}
			else
				$errorMessage = 'Les données ne sont pas correctes';
		}

		$titlePage = 'Modifier post';

		include 'views/template/header.php';
		include 'views/modif_post.php';
		include 'views/template/footer.php';
	}
	else
		$faute = true;
}
else $faute = true;

if ($faute)
	header ('Location: ./'); // Redirection vers la page d'accueil