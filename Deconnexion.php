<?php
session_start(); //Autorise l'utilisation de tous ce qui touche aux sessions

if(isset($_SESSION['uid'])) //Si l'utilisateur est connecté
{
	session_destroy(); //Détruit les variables de session
	header('Location: ./Index.php');
}
else
{
	header('Location: ./Index.php');
}
?>
