<!-- Auteurs: DIEUDONNE Loïc, GAUVIN Thomas -->

<?php 

session_start(); //Permet d'utiliser les sessions et leur variables

//Initialisation des variables
$errorMessage = '';
$faute = false;

//connexion db
require("connexion.php");
$pdo=connect_bd();

$select = ("SELECT titre , description , cid FROM categorie"); //Récupération des catégories dans la BDD
$statement = $pdo->query($select);
$categorie = $statement->fetchAll(PDO::FETCH_ASSOC);

$select = ("SELECT titre , description , cid FROM sujet"); //Récupération des catégories dans la BDD
$statement = $pdo->query($select);
$sujet = $statement->fetchAll(PDO::FETCH_ASSOC);


$select = ("SELECT * FROM utilisateur"); // Récupération des données de la table utilisateur
$statement = $pdo->query ( $select );
$utilisateur = $statement->fetchAll ( PDO::FETCH_ASSOC );

// Vérification du formulaire une fois que celui-ci est rempli
if (! empty ( $_POST ['pseudo'] )) 	// Uniquement $nom car tous les champs sont requis ( required )
{
	// Récupération des données du formulaire
	$pseudo = ($_POST ['pseudo']);
	$mdp = ($_POST ['mdp']);

	for($i=0; $i<count($utilisateur); $i++)
	{
		$uid = $utilisateur[$i]['uid']; // Récupère le numéro d'id de la personne
		$recuppseudo = $utilisateur[$i]['Pseudonyme'];
		$recupmdp = $utilisateur[$i]['Mot de passe'];
		$admin = $utilisateur[$i]['Administrateur'];
			
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
		
		<?php if(!empty($errorMessage)):?> <!-- Rencontre-t-on une erreur ?  -->
				<p class="alert alert-danger"> <?= htmlspecialchars($errorMessage) ?> </p>
		<?php endif;?>
		<section class="container"> <!-- Section centrale -->
			<header>
				<h1> Bienvenue sur le forum !! </h1>
			</header>
		<?php for($i = 0 ; $i<count($categorie); $i++) 
			{
				$test = $categorie[$i]['cid'];
				$select = ("SELECT titre , description , cid FROM sujet WHERE cid=".$test.""); //  Récupération des sujet dans la BDD
				$statement = $pdo->query($select);
				$sujet = $statement->fetchAll(PDO::FETCH_ASSOC); ?>
			<!-- Affichage des catégories -->
					<section  class="panel panel-primary"> 
						<div class="panel-heading">
							<h1 class="panel-title" ><?= $categorie[$i]['titre']?></h1>
						</div>
							<p class="panel-body"><?= $categorie[$i]['description']?></p>
										<ul class="list-group">
						<!-- Affichage des sujets, premier jets -->
						<?php for($j = 0 ; $j<count($sujet) ; $j++) :?>
							<a href="Sujet.php?Titresujet=<?= $sujet[$j]['titre'] ?>" class="list-group-item"> <h4><?= $sujet[$j]['titre']?> :</h4><p> <?= $sujet[$j]['description'] ?></p> </a>			
						<?php endfor;?>
						</ul>
				 </section>
		<?php }?>
		</section>
	</body>
	<footer >
	</footer>
</html>