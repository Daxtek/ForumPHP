<?php 
require('init-page.php');

if (isset( $_GET['sid'] ) && $Requests->sujetExist($_GET['sid'])) {
	$sujet_id = $_GET['sid'];
	$sujet = $Requests->getSujet($sujet_id);

	if ($_SESSION['utilisateur_id'] == $sujet[0]['utilisateur_id'] || $_SESSION['admin']) {
		$Requests->deleteSujet($sujet_id);
	}
}

header ('Location: ./'); // Redirection vers la page d'accueil