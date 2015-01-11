<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->
<?php

require('init-page.php');



	require('ConnexionUser.php');
	

//Initialisation des variables
$messageCreation = '';
$faute = false;


if (isset( $_GET['sid'] )) // Si l'on accède à la page via le lien du sujet dans la page d'accueil
{
	
	// Récupération du sujet
	$sujet = $Requests->getSujet($_GET['sid']);
	$post = $Requests->getPostsBySubject($_GET['sid']);
	
	if ( !empty( $_POST['titre']) && !empty($_POST['texte'])) // Vérifie que tous les champs du formulaire de post ont été remplis 
	{
		if(isset($_SESSION['uid'])) // Vérifie que l'utilisateur est connecté
		{
			//Variables du post à ajouter dans la BDD
			$titre=($_POST ['titre']);
			$texte=($_POST ['texte']);
			//Récupération de l'id de l'utilisateur créateur de la catégorie
			$uid = $_SESSION['uid'];
			$sid = $_GET['sid']; // l'id du sujet
			$cid = $sujet[0]['cid']; // l'id de la catégorie
			
			//Vérifications	
			for($i = 0 ; $i < count($post); $i++ ) //Parcours des titres
			{
				// Si le post existe déjà dans la BDD
				if ($post[$i]['Titre'] == $titre)
				{
					$errorMessage .= " Le post que vous voulez créer existe déjà. ";
					$faute = true;
				}
			}
			
			//Si l'ensemble des données sont correctes on ajoute le nouveau sujet dans la table sujet
			if($faute != true)
			{
				
				if ($Requests->addPost($sid, $cid, $uid, $titre, $texte)) //Si l'insertion du post s'est bien faite donc si le nouveau post existe dans la BDD
				{
					header ('Location: ./Sujet.php?sid='.$sid.''); //Réactualisation de la page
				}
				else
				{
					$errorMessage .= " Il y a eu une erreur le post n'a pas été créer, veuillez réessayer"; //Message d'erreur
				}
			}
		}
		else
		{
			$errorMessage .= " Vous devez être connecté pour poster"; //Message d'erreur
		}
	}
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
		<link rel="stylesheet" type="text/css" href="css/VerificationFormulaire.css" />
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
    
    <section class="container">
    <h3> Bienvenue sur le sujet <?= $sujet[0]['Titre']?> </h3>
		<!-- Affichage des sujets -->
		<section  class="panel panel-primary"> 
			<div class="panel-heading">
				<h1 class="panel-title" ><?= $sujet[0]['Titre']?></h1>
			</div>
			<p class="panel-body"><?= $sujet[0]['Description']?></p>
				<ul class="list-group">
				<!--Mettre les posts ici -->
				<?php for($j = 0 ; $j<count($post) ; $j++) :?>
					<li href="#" class="list-group-item"> <h4><?= $post[$j]['Titre']?> :</h4><p> <?= $post[$j]['Texte'] ?></p> </li>			
				<?php endfor;?>
				
				
				<section class="container"> <!-- Section du formulaire de nouveau post -->
					<h4>Répondre :</h4>
					<form  name="formPost" action="#" method="POST" onsubmit="return verifForm()">
					<div class="row">
						<div class="form-group col-lg-5 col-md-5">
							<label  for="idtitre"> Titre : </label>
								<input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}"" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required ><br>
						</div>		
						<div class="form-group col-lg-5 col-md-5">	
							<label  for="idtexte"> Texte : </label>
								<textarea class="form-control"  id="idtexte" name="texte" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
						</div>
					</div>
						<input class="btn btn-default" type="submit" value="Valider">
						<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
					</form>	
				</section>	
					<?php if(!empty($errorMessage)):?> <!-- Rencontre-t-on une erreur ?  -->
						<p class="alert alert-danger"> <?= htmlspecialchars($errorMessage) ?> </p>
					<?php elseif(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
						<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
					<?php endif;?>	
					</ul>
				
			</section>
    </section>
    </body>
  </html>
  <script>
  /* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
function verifForm()
{
	titre = document.formPost.titre.value;
	
	var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(titre)) 
	{	
		alert("le titre n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}
</script>
  