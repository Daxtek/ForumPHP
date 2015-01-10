<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php
session_start(); // Autorise l'utilisation des variables de session

if(!isset($_SESSION['uid'])) //Si la variable de session n'a pas été créer ( si la personne n'est pas connectée au site )
{
	header('Location: ./Index.php'); //Redirection vers la page d'accueil
}

//Initialisation des variables
$errorMessage = '';
$messageCreation = '';
$faute = false;
$nouveauSujet = false; // Boolean de vérification de la création du nouveau sujet

//connexion db
require("connexion.php");
$pdo=connect_bd();


$select = ("SELECT titre , cid FROM categorie"); //Récupération des catégories dans la BDD
$statement = $pdo->query($select);
$categorie = $statement->fetchAll(PDO::FETCH_ASSOC);

//Vérification du formulaire une fois que celui-ci est rempli
if ( !empty( $_POST ['titre'])) // Uniquement $titre car les autres champs necessaires sont requis ( required )
{
	//Récupération des données du formulaire
	$titre=($_POST ['titre']);
	$description=( $_POST ['description']);
	$cid = ($_POST['categorie']);
	//Création de la date
	$date = date('Y').'-'.date('m').'-'.date('d') ;
	//Récupération de l'id de l'utilisateur créateur de la catégorie
	$uid = $_SESSION['uid'];
	
	
	//Vérification de l'existence du titre
	$select = ("SELECT titre , cid FROM sujet WHERE cid=".$cid.""); //Récupération des titres dans la BDD
	$statement = $pdo->query($select);
	$tableauTitre = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	
	for($i = 0 ; $i < count($tableauTitre); $i++ ) //Parcours des titres
	{
		// Si le titre existe déjà dans la BDD
		if ($tableauTitre[$i]['titre'] == $titre)
		{
			$errorMessage .= " Le sujet que vous voulez créer existe déjà. ";
			$faute = true;
		}
	}
	
	//Vérifivation qu'une catégorie à bien été choisie
	if($cid == 0)
	{
		$errorMessage .= " Veuillez séléctionner une catégorie. ";
		$faute = true;
	}
	
	//Si l'ensemble des données sont correctes on ajoute le nouveau sujet dans la table sujet
	if($faute != true)
	{
		//le champs vide est le champs de l'id qui est créer automatiquement , 0000-00-00 corespond a la date de fermeture , 1 car le sujet et ouvert , les deux dernier 0 sont dans l'ordre le 1er et le dernier post
		$sql="insert into sujet values ( '' , '$cid' , '$uid', '$date' , '0000-00-00' , '$titre' ,'$description' , '1' , '0' , '0') "; 
		$statement = $pdo->query($sql);
		
		/*
		 * Vérification que le sujet est bien ajouté dans la base ! 
		 * C'est une double sécurité, bonne idée de l'appliquer partout ?
		 */
			
			if ($statement) //Si l'insertion du sujet s'est bien faite donc si le nouveau post existe dans la BDD 
			{
				$messageCreation = 'Le sujet '. $titre .' à été crée !'; //Message de succés
			}
			else 
			{
				$errorMessage .= " Il y a eu une erreur le sujet n'a pas été créer, veuillez réessayer"; //Message d'erreur
			}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/VerificationFormulaire.css" />
		<title> Création sujet</title>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top"><!-- Barre de navigation principal -->
		     <div class="container">
		     	<div class="navbar-header">
		        	<a class="navbar-brand" href="Index.php">Forum PHP</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
					<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
		        </div>
		   	</div>
	    </nav>
	    <section class="container"> <!-- Section central -->
		<header>
			<h1> Formulaire de création de sujet</h1>
		</header>
		<form  name="formSujet" action="#" method="POST" onsubmit="return verifForm()">
			<label  for="idtitre"> Titre : </label><input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}"" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required ><br>
			<label  for="iddescrip"> Description : </label><textarea class="form-control"  id="iddescrip" name="description" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
			<label  for="iddescrip"> Catégorie : </label>
			<select class="form-control" name="categorie">
					<option value="select"> Sélectionnez la catégorie à laquelle le sujet appartient </option>  
					<?php for($i = 0 ; $i<count($categorie); $i++) : ?> <!-- Affiche les différents choix possible à l'aide d'une boucle  -->
						<option value=<?= $categorie[$i]['cid']?>><?=  $categorie[$i]['titre'] ?> </option> 
					<?php endfor;?>
				</select>
				<br>
			<input class="btn btn-default" type="submit" value="Valider">
			<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
		</form>
		<?php if(!empty($errorMessage)):?> <!-- Rencontre-t-on une erreur ?  -->
				<p class="alert alert-danger"> <?= htmlspecialchars($errorMessage) ?> </p>
		<?php elseif(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
			<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
		<?php endif;?>
	</section>
	<footer class="container">
	<!-- Pied de page avec le lien vers l'accueil -->
		<a class="btn btn-primary navbar-btn" href="Index.php"> Retour </a>
	</footer>
	</body>
</html>
<script>
	
/* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
function verifForm()
{
	titre = document.formSujet.titre.value;
	
	var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(titre)) 
	{	
		alert("le titre n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}