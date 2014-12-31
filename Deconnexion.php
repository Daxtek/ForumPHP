<?php
session_start(); //Autorise l'utilisation de tous ce qui touche aux sessions

if(isset($_SESSION['uid']))
{
	session_destroy(); //Détruit les variables de session
}
else
{
	header('Location: ./Index.php');
}
?>
<html lang="fr">
<head>
	<meta charset="utf-8"/>
<title>Deconnexion</title>
</head>
<body>
	<H1>Déconnexion </H1>
	<p> Vous êtes déconnecté </p>
	<A HREF="Index.php"> Page d'accueil </A>
</body>
</html>	