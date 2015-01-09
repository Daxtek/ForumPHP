<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->
<?php

session_start(); //Permet d'utiliser les sessions et leur variables

//connexion db
require("connexion.php");
$pdo=connect_bd();

if (isset( $_GET['Titresujet'] )) // Si l'on accède à la page via le lien du sujet dans la page d'accueil
{
	echo "Vous avez choisi le sujet". $_GET['Titresujet'];
	echo "Récupérer les données du sujet avec la BDD";
	
	$select = ("SELECT titre , description , cid FROM sujet WHERE titre=".$_GET['Titresujet']." "); //Récupération des catégories dans la BDD
	$statement = $pdo->query($select);
	$sujet = $statement->fetchAll(PDO::FETCH_ASSOC);
	
}
else
{
	header ('Location: ./Index.php'); //Redirection vers la page d'accueil
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/Index.css" rel="stylesheet">
		<title> Accueil | Forum PHP </title>
	</head>
	<body >
		<nav class="navbar navbar-inverse navbar-fixed-top"><!-- Barre de navigation principal -->
	      <div class="container">
	        <div class="navbar-header">
	          <a class="navbar-brand" href="Index.php">Forum PHP</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
			<?php if (!isset($_SESSION['admin'])): ?> <!--  Si la variable de session n'a pas été créer ( si la personne n'est pas connectée au site ) -->
				<form name="formConnexion" action="#" method="POST" class="navbar-form navbar-right">
		            <div class="form-group">
		              <input type="text" name="pseudo" size="20" maxlength="20"  placeholder="Pseudonyme" class="form-control" required>
		            </div>
		            <div class="form-group">
		              <input type="password" placeholder="Mot de passe" class="form-control" name="mdp" required>
		            </div>
		            <button type="submit" class="btn btn-success">Se connecter</button>
		            <a class="btn btn-primary" href="Inscription.php">Inscription</a>
	          	</form>
          	<?php else: ?> <!-- Si la personne est connecté -->
          		<?php if(($_SESSION['admin']) == '1'): ?> <!--  Si la personne qui est connecté est pas un administrateur alors elle peut accéder aux rubriques qui suivent -->
          			<ul class="nav navbar-nav">
						<li><a  href="Inscription.php"> Inscrire un nouvel utilisateur </a></li>
						<li><a  href="CreationSujet.php"> Créer Sujet </a></li>
						<li><a  href="CreationCategorie.php"> Créer Catégorie </a></li>
					</ul>
					<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
          		<?php else: ?> <!-- Si c'est un simple utilisateur -->
          			<ul class="nav navbar-nav">
						<li><a  href="CreationSujet.php"> Créer Sujet </a></li>
					</ul>
					<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
				<?php endif; ?>
			<?php endif; ?>

	        </div>
	      </div>
    </nav>
    </body>
  </html>