<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<!-- 
	To do: 
		
		Stylisé la page
	-->



<?php

session_start(); // Autorise l'utilisation des variables de session

if(isset ($_SESSION['pseudo'])  )
{
	header('Location: ./Index.php');
}

//Initialisation des variables
$errorMessage = '';
$faute = false;

//Connexion à la base de donnée
require("connexion.php");
$pdo=connect_bd();
// Récupération des données de la table utilisateur
$select = ("SELECT * FROM utilisateur"); 
$statement = $pdo->query ( $select );
$row = $statement->fetchAll ( PDO::FETCH_ASSOC );

// Vérification du formulaire une fois que celui-ci est rempli
if (! empty ( $_POST ['pseudo'] )) 	// Uniquement $nom car tous les champs sont requis ( required )
{
	// Récupération des données du formulaire
	$pseudo = ($_POST ['pseudo']);
	$mdp = ($_POST ['mdp']);

	for($i=0; $i<count($row); $i++) 
	{
		$uid = $row[$i]['uid']; // Récupère le numéro d'id de la personne
		$recuppseudo = $row[$i]['Pseudonyme'];
		$recupmdp = $row[$i]['Mot de passe'];
		$admin = $row[$i]['Administrateur'];
		echo $admin;
		
		// Si le pseudonyme existe déjà dans la BDD
		if ($recuppseudo == $pseudo && $recupmdp == $mdp) 
		{
			// Créer les variables de sessions 
			$_SESSION ['pseudo'] = $pseudo;
			$_SESSION ['uid'] = $uid;
			$_SESSION ['admin'] = $admin;
			header ('Location: ./Index.php'); //Redirection vers la page d'accueil
		} 
		else 
		{
			$errorMessage = 'Vos identifiants sont faux'; //Message d'erreur
		}
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Inscription.css" />
		<title>Page de connexion</title>
	</head>
	<body>
		<header>
			<h1>Formulaire de connexion</h1>
		</header>
		<form name="formConnexion" action="#" method="POST">
			<label for="idpseudo"> Pseudonyme : </label><input type="text" id="idpseudo" name="pseudo" size="20" maxlength="20" required><br>
			<label for="idmdp"> Mot de passe : </label><input type="password" id="idmdp" name="mdp" required><br> <input type="submit" value="Valider">
			<inputtype="reset" value="Reinitialiser" />
		</form>
	
	<?php 
		// Rencontre-t-on une erreur ?
		if(!empty($errorMessage)) echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
	?>
	
	</body>
<footer>
	<!-- Pied de page avec le lien vers l'accueil -->
	<A HREF="Index.php"> Page d'accueil </A>
</footer>
</html>
