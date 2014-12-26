<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Page d'incscription</title>
	</head>
	<body>
	<!-- Ajouter des vérif js ?? -->
		<header>
		<h1> Formulaire d'inscription</h1>
	</header>
	<form name="formInscription" action="#" method="POST">
		
		<label> Nom : </label><input type="text" name="nom" size="20" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un nom contenant uniquement des caractère alphabétiques ( accents autorisés)" required  oninput="verifNom(this)"> <br>
		<label> Prénom : </label><input type="text" name="prenom" required > <br>
		<label> Email : </label><input type="email" name="email" required ><br>
		<label> Pseudonyme : </label><input type="text" name="pseudo" required ><br>
		<label> Mot de passe : </label><input type="password" name="mdp" required ><br>
		<label> Comfirmer le mot de passe : </label><input type="password" name="mdpConfirmation" required title="Les deux champs doivent correspondre" ><br>
		<label> Pseudonyme : </label><input type="text" name="pseudo" required title="Pseudonyme sous lequel les autres utilisateurs vous verront" ><br>
		
		<input type="submit"> 
		
		
	</form>

	</body>
</html>

<?php 

//connexion db
require("connexion.php");
$pdo=connect_bd();
$select = ("SELECT * FROM utilisateur");
$statement = $pdo->query($select);
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($row);




?>