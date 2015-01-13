<?php 
require('init-page.php');

if (isset( $_GET['pid'] ) && $Requests->postExist($_GET['pid'])) { // Si l'on accède à la page via le lien du sujet dans la page d'accueil

	$pid = $_GET['pid'];
	$post = $Requests->getPost($pid);

	if ($_SESSION['uid'] == $post['utilisateur_id'] || $_SESSION['admin']) {
		$Requests->deletePost($pid);
	}
	header ('Location: ./Sujet.php?sid='.$post['sujet_id'].''); // Retour vers le sujet
}
else
	header ('Location: ./Index.php'); // Redirection vers la page d'accueil