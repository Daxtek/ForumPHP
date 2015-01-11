<?php

require('init-page.php');

//Initialisation des variables
$messageFermeture = '';

//Test si on est déjà connecté

	require('ConnexionUser.php');

// Récupération des catégories et des sujets
$forum = $Requests->getCategoriesAndSujets();


// Vérification du formulaire de fermeture de sujet une fois que celui-ci est rempli
if (isset ($_POST ['SujetAFermeID']) && !empty ( $_POST ['SujetAFermeID'] )) 	
{
	if($Requests->closeSubject($_POST ['SujetAFermeID']))
	{
		header('Location: ./Index.php'); //Réactualise la page
	}
	else
	{
		$errorMessage.= 'Le sujet n\'a pas été fermé';
	}
}

// Vérification du formulaire d'ouverture de sujet une fois que celui-ci est rempli
if (isset ($_POST ['SujetAReouvrirID']) && !empty ( $_POST ['SujetAReouvrirID'] ))
{
	if($Requests->openSubject($_POST['SujetAReouvrirID']))
	{
		header('Location: ./Index.php'); //Réactualise la page
	}
	else
	{
		$errorMessage.= 'Le sujet n\'a pas été réouvert';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
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
		<?php elseif(!empty($messageFermeture)): ?><!-- Message du succès de la création --> 
				<p class="alert alert-success"><?=  htmlspecialchars($messageFermeture) ?> </p>
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
					<?php if ($sujet['Statut']== '1'): ?> <!-- Si le sujet est ouvert -->
						<a href="Sujet.php?sid=<?= $sujet['sid'] ?>" class="list-group-item"> 
							<h4><?= $sujet['Titre']?> :</h4>
							<p> <?= $sujet['Description'] ?></p> 
						</a>
					<?php elseif ($sujet['Statut']== '0' ):?> <!-- Si le sujet est fermé -->
						<li class="list-group-item"> 
							<h4><?= $sujet['Titre']?> :</h4>
							<p> <?= $sujet['Description'] ?></p> 		
						</li>
						<p> Ce sujet est fermé</p>
					<?php endif;?>	
					<?php if (isset($_SESSION['admin'])): ?> <!-- Si le sujet est ouvert et que l'utilisateur est un administrateur -->
						<?php if ($sujet['Statut']== '1'  && $_SESSION['admin'] == '1'):?>
							<form name="formFermetureSujet" action="#" method="POST">
								<input type="hidden" name="SujetAFermeID" value="<?= $sujet['sid']?>" required>
								<button type="submit" class="btn btn-warning"> Fermez le sujet </button>
							</form> 
						<?php elseif ($sujet['Statut']== '0'  && $_SESSION['admin'] == '1'):?> <!-- Si le sujet est fermé et que l'utilisateur est un administrateur -->
							<form name="formOuvertureSujet" action="#" method="POST">	
								<input type="hidden" name="SujetAReouvrirID" value="<?= $sujet['sid']?>" required>
								<button type="submit" class="btn btn-warning"> Réouvrir le sujet </button> 
							</form>		
						<?php endif;?>
					<?php endif;?>
				<?php endforeach ?>
				</ul>
			 </section>
		<?php endforeach ?>
		</section>
	</body>
	<footer >
	</footer>
</html>
