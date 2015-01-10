<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php 

session_start(); //Permet d'utiliser les sessions et leur variables

function debug($var) {
	echo '<pre>';
	var_export($var);
	echo '</pre>';
}

//Initialisation des variables
$errorMessage = '';

require("requests.php");