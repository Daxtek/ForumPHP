<?php

require('init-page.php');

// Récupération des catégories et des sujets
$forum = $Requests->getCategoriesAndSujets();

// ==== Formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (
		isset($_POST['pseudo']) &&
		!empty($_POST['pseudo']) &&
		isset($_POST['mdp']) &&
		!empty($_POST['mdp'])
	) {
		// Récupération des données du formulaire
		$pseudo = ($_POST['pseudo']);
		$mdp = ($_POST['mdp']);
		$user = $Requests->userConnect($pseudo, $mdp);
		// Si le pseudonyme existe déjà dans la BDD
		if ($user) {
			// Créer les variables de sessions
			$_SESSION['pseudo'] = $user['Pseudonyme'];
			$_SESSION['uid'] = $user['uid'];
			$_SESSION['admin'] = $user['Administrateur'];
			header ('Location: ./Index.php'); //Redirection vers la page d'accueil
		}
		else {
			$errorMessage .= "Vos identifiants sont faux.\n"; //Message d'erreur
		}
	}
	else
		$errorMessage .= "Vos identifiants sont faux.\n";
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
		
		<?php if(!empty($errorMessage)):?>
			<p class="alert alert-danger"> <?= htmlspecialchars($errorMessage) ?> </p>
		<?php endif;?>


		<section class="container"> <!-- Section centrale -->
			<header>
				<h1> Bienvenue sur le forum !! </h1>
			</header>
		<?php foreach ($forum as $categorieKey => $categorie): ?>
			<!-- Affichage des catégories -->
			<section  class="panel panel-primary"> 
				<div class="panel-heading">
					<h1 class="panel-title" ><?= $categorie['Titre']?></h1>
				</div>
				<p class="panel-body"><?= $categorie['Description']?></p>
								<ul class="list-group">
				<!-- Affichage des sujets, premier jets -->
				<?php foreach ($categorie['sujets'] as $sujetKey => $sujet): ?>
					<a href="Sujet.php?Titresujet=<?= $sujet['Titre'] ?>" class="list-group-item">
						<h4><?= $sujet['Titre']?> :</h4>
						<p> <?= $sujet['Description'] ?></p>
					</a>
				<?php endforeach ?>
				</ul>
			 </section>
		<?php endforeach ?>
		</section>
	</body>
	<footer >
	</footer>
</html>
