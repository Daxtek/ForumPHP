<?php 
require('init-page.php');

if (isset( $_GET['pid'] ) && $Requests->postExist($_GET['pid'])) {

	$post_id = $_GET['pid'];
	$post = $Requests->getPost($post_id);
	$sujet = $Requests->getSujet($post['sujet_id']);

	if ($_SESSION['utilisateur_id'] == $post['utilisateur_id'] || $_SESSION['admin']) {
		if ($post_id != $sujet['premier_post'])
			$Requests->deletePost($post_id);
	}
	header ('Location: ./sujet.php?sid='.$post['sujet_id'].''); // Retour vers le sujet
}
else
	header ('Location: ./'); // Redirection vers la page d'accueil