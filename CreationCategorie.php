<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php
session_start(); // Autorise l'utilisation des variables de session

if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
{
	if(($_SESSION['admin']) == '0') //Si la personne qui est connecté n'est pas un administrateur alors elle ne peut pas créer d'autres catégories
	{
		header('Location: ./Index.php'); //Redirection vers la page d'accueil
	}
}

//Initialisation des variables
$errorMessage = '';
$messageCreation = '';
$faute = false;

//connexion db
require("connexion.php");
$pdo=connect_bd();


//Vérification du formulaire une fois que celui-ci est rempli
if ( !empty( $_POST ['titre'])) // Uniquement $titre car c'est le seul champs requis ( required )
{
	//Récupération des données du formulaire
	$titre=($_POST ['titre']);
	$description=( $_POST ['description']);
	//Création de la date
	$date = date('Y').'-'.date('m').'-'.date('d') ;
	//Récupération de l'id de l'utilisateur créateur de la catégorie
	$uid = $_SESSION['uid'];
	
	//Vérification de l'existence du titre
	$select = ("SELECT titre FROM categorie"); //Récupération des titres dans la BDD
	$statement = $pdo->query($select); 
	$row = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	for($i = 0 ; $i < count($row); $i++ ) //Parcours des titres
	{
		// Si le titre existe déjà dans la BDD
		if ($row[$i]['titre'] == $titre)
		{
			$errorMessage .= " La catégorie que vous voulez créer existe déjà. ";
			$faute = true;
		}
	}
	
	//Si l'ensemble des données sont correctes on ajoute la nouvelle catégorie dans la table categorie
	if($faute != true)
	{
		//Insértion de la catégorie et ses données dans la base
		$sql="insert into categorie values ( '' , '$titre', '$uid', '$date' , '$description' ) "; //le champs vide est le champs de l'id qui est créer automatiquement
		$statement = $pdo->query($sql);
		$messageCreation = 'La catégorie '. $titre .' à été crée !'; //Message de succées de création
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title> Création catégorie</title>
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
			<h1> Formulaire de création de catégories</h1>
		</header>
		<form name="formCategorie" action="#" method="POST" onsubmit="return verifForm()">
			
			<label for="idtitre"> Titre : </label><input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required > <br>
			<label for="iddescrip"> Description : </label><textarea class="form-control" id="iddescrip" name="description" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea> <br>
	
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
	titre = document.formCreation.titre.value;
	
	var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(titre)) 
	{	
		alert("le titre n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}