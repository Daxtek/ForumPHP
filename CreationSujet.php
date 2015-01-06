<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<!-- 
	To do: 
		
		Stylisé la page
	-->
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
	$select = ("SELECT titre FROM sujet"); //Récupération des titres dans la BDD
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
		$messageCreation = 'Le sujet '. $titre .' à été crée !';
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title> Création sujet</title>
	</head>
	<body>
		<nav class="navbar navbar-inverse"><!-- Barre de navigation principal -->
		     <div class="container">
		     	<div class="navbar-header">
		        	<a class="navbar-brand" href="Index.php">Forum PHP</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
					<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>
					<a class="btn btn-primary navbar-btn navbar-right" href="Index.php"> Page d'accueil </a>
		        </div>
		   	</div>
	    </nav>
		<header>
			<h1> Formulaire de création de sujet</h1>
		</header>
	<form name="formSujet" action="#" method="POST" onsubmit="return verifForm()">
		
		<label for="idtitre"> Titre : </label><input type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}"" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required > <br>
		<label for="iddescrip"> Description : </label><textarea  id="iddescrip" name="description" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea> <br>
		<label for="iddescrip"> Catégorie : </label>
			<select name="categorie">
				<option value="select"> Sélectionnez la catégorie à laquelle le sujet appartient </option>  
				<?php 
					//Affiche les différents choix possible à l'aide d'une boucle 
					for($i = 0 ; $i<count($categorie); $i++)
					{
						echo '<option value='. $categorie[$i]['cid']. '>'. $categorie[$i]['titre'] .'</option>'; 
					}
				?>
			</select><br>
		
		<input type="submit" value="Valider">
		<input type="reset" value="Reinitialiser"/> 
	</form>
	
	<?php 
		// Rencontre-t-on une erreur ?
		if(!empty($errorMessage)) echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
		//Message du succès de la création du sujet
		elseif(!empty($messageCreation)) echo '<p>', htmlspecialchars($messageCreation) ,'</p>';
	?>
	
	</body>
	<footer >
	<!-- Pied de page avec le lien vers l'accueil -->
		<a class="btn btn-primary navbar-btn" href="Index.php"> Page d'accueil </a>
	</footer>
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