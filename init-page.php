<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php 

session_start(); //Permet d'utiliser les sessions et leur variables

function debug($var) {
	echo '<pre>';
	var_export($var);
	echo '</pre>';
}

function debugDie($var) {
	echo '<pre>';
	var_export($var);
	echo '</pre>';
	die();
}

//Initialisation des variables
$titlePage = 'ForumPHP';
$errorMessage = '';

require("requests.php");