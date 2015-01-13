<?php 
require('init-page.php');

if (isset( $_GET['pid'] ) && $Requests->postExist($_GET['pid'])) { // Si l'on accède à la page via le lien du sujet dans la page d'accueil

	$post_id = $_GET['pid'];
	$post = $Requests->getPost($post_id);

	if ($_SESSION['uid'] == $post['utilisateur_id'] || $_SESSION['admin']) {
		$Requests->deletePost($post_id);
	}
	header ('Location: ./sujet.php?sid='.$post['sujet_id'].''); // Retour vers le sujet
}
else
	header ('Location: ./'); // Redirection vers la page d'accueil