<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<!-- 
	To do: 
		
		Stylisé la page
	-->

<?php 
session_start(); // Autorise l'utilisation des variables de session

if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
{
	if(($_SESSION['admin']) == '0') //Si la personne qui est connecté n'est pas un administrateur alors elle ne put pas créer d'autres comptes
	{
		header('Location: ./Index.php'); //Redirection vers la page d'accueil
	}
}

//Initialisation des variables
$errorMessage = '';
$messageInscription ='';
$faute = false;

//connexion db
require("connexion.php");
$pdo=connect_bd();

//Vérification du formulaire une fois que celui-ci est rempli
if ( !empty( $_POST ['nom'])) // Uniquement $nom car tous les champs sont requis ( required ) 
{
	//Récupération des données du formulaire
	$nom=($_POST ['nom']);
	$prenom=( $_POST ['prenom']);
	$mail=( $_POST ['email']);
	$pseudo=( $_POST ['pseudo']);
	$mdp=( $_POST ['mdp']);
	$mdpConfirmation=( $_POST ['mdpConfirmation']);
	$date = date('Y').'-'.date('m').'-'.date('d') ;
	
	//Vérification de l'existence du pseudonyme
		//Récupération des pseudonymes dans la BDD
		$select = ("SELECT pseudonyme FROM utilisateur");
		$statement = $pdo->query($select);
		$row = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		for($i = 0 ; $i < count($row); $i++ )
		{
			// Si le pseudonyme existe déjà dans la BDD 
			if ($row[$i]['pseudonyme'] == $pseudo)
			{
				$errorMessage .= " Le pseudonyme que vous avez choisi existe déjà. ";
				$faute = true;
			}
		}
		
	//Vérification de l'existence du mail
		//Récupération des mails dans la BDD
		$select = ("SELECT mail FROM utilisateur");
		$statement = $pdo->query($select);
		$row = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		for($i = 0 ; $i < count($row); $i++ )
		{
			// Si le mail existe déjà dans la BDD
			if ($row[$i]['mail'] == $mail)
			{
				$errorMessage .= " Le mail que vous avez choisi existe déjà. ";
				$faute = true;
			}
		}
		
	//Vérification du mot de passe	
		if ( $mdp != $mdpConfirmation)
		{
			$errorMessage .= " Les mots de passe ne correspondent pas. ";
			$faute=true;
		}		
		
	//Si l'ensemble des données sont correctes on ajoute le nouveau membre dans la table inscription
		if($faute != true)
		{
			$sql="insert into utilisateur values ( '$pseudo', '$mdp', '$mail', '$date' ,	'0', '0', '' , '$nom' , '$prenom' ) ";
			$statement = $pdo->query($sql);
			$messageInscription = 'Vous êtes inscrit ! '. $pseudo;
		}
		
} ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title> Page d'incscription</title>
	</head>
	<body>
		<header>
		<h1> Formulaire d'inscription</h1>
	</header>
	<form name="formInscription" action="#" method="POST" onsubmit="return verifForm()">
		
		<label for="idnom"> Nom : </label><input type="text" id="idnom" name="nom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un nom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
		<label for="idprenom"> Prénom : </label><input type="text" id="idprenom" name="prenom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un prénom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
		<label for="idemail"> Email : </label><input type="email" id="idemail" name="email" maxlength="100" pattern="[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}" title="Veuillez rentrez un email valide" required ><br>
		<label for="idmdp"> Mot de passe : </label><input type="password" id="idmdp" name="mdp" required ><br>
		<label for="idmdpConfirmation"> Confirmer le mot de passe : </label><input type="password"  id="idmdpConfirmation" name="mdpConfirmation" required title="Les deux champs doivent correspondre" ><br>
		<label for="idpseudo"> Pseudonyme : </label><input type="text" id="idpseudo" name="pseudo" size="20" maxlength="20" required pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789]{2,}" title="Le pseudonyme peut contenir des chiffres et des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" ><br>
		
		<input type="submit" value="Valider">
		<input type="reset" value="Reinitialiser"/> 
		
		
	</form>
	
	<?php 
		// Rencontre-t-on une erreur ?
		if(!empty($errorMessage)) echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
		//Message du succès de l'inscription
		elseif(!empty($messageInscription)) echo '<p>', htmlspecialchars($messageInscription) ,'</p>';
	?>
	
	</body>
	<footer >
	<!-- Pied de page avec le lien vers l'accueil -->
		<A HREF="Index.php"> Page d'accueil </A>
	</footer>
</html>
<script>
	
/* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
function verifForm()
{
	nom = document.formInscription.nom.value;
	prenom = document.formInscription.prenom.value;
	mail = document.formInscription.email.value;
	pseudo = document.formInscription.pseudo.value;
	
	var reg = new RegExp("^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(nom)) 
	{	
		alert("le nom n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}

	if (!reg.test(prenom)) 
	{	
		alert("le prenom n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
	var reg = new RegExp("^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
	if (!reg.test(pseudo)) 
	{	
		alert("le pseudo n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}

	var reg = new RegExp("^[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}$"); /* Ici on doit ajouter un + avant le @ car on a pas defini la taille de la zone ! */
	if (!reg.test(mail)) 
	{
		alert("le mail n'est pas valide");
		return false; //Empeche le submit si les vérifications ne sont pas valides
	}
}	

</script>




