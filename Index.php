<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php 

session_start(); //Permet d'utiliser les sessions et leur variables

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Accueil | Forum PHP </title>
	</head>
	<body>
		<p> Bienvenue sur le forum !! </p>
		<ul>
			<li>
				<a href="Inscription.php">Page d'inscription </a>
			</li>
			<li>
				<a href="ConnexionSite.php">Page de connexion </a>
			</li>
			<?php
				if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
				{
					echo '<li><a href="CreationSujet.php">Créer Sujet </a></li>	';
				}
				if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
				{
					if(($_SESSION['admin']) == '1') //Si la personne qui est connecté est pas un administrateur alors elle peut accéder à la création de catégorie
					{
						echo '<li><a href="CreationCategorie.php">Créer Catégorie </a></li>	';
					}
				}
			?>		
		</ul>
		
		
	
	</body>
	<footer >
	<?php 
		
		// Pied de page avec le lien vers la déconnexion 
		if(isset ($_SESSION['uid']))
		{
			echo '<A HREF="Deconnexion.php"> Deconnexion </A> ';
		}
	?>
	</footer>
</html>