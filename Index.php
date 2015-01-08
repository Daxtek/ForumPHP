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
	          <a class="navbar-brand" href="#">Forum PHP</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	        <?php
				if(!isset($_SESSION['admin'])) //Si la variable de session n'a pas été créer ( si la personne n'est pas connectée au site )
				{
					echo '<form name="formConnexion" action="#" method="POST" class="navbar-form navbar-right">
				            <div class="form-group">
				              <input type="text" name="pseudo" size="20" maxlength="20"  placeholder="Pseudonyme" class="form-control" required>
				            </div>
				            <div class="form-group">
				              <input type="password" placeholder="Mot de passe" class="form-control" name="mdp" required>
				            </div>
				            <button type="submit" class="btn btn-success">Se connecter</button>
				            <a class="btn btn-primary" href="Inscription.php">Inscription</a>
			          	</form>';
				}
				else //Si la personne est connecté
				{
					if(($_SESSION['admin']) == '1') //Si la personne qui est connecté est pas un administrateur alors elle peut accéder à la création de catégorie
					{
						echo '<ul class="nav navbar-nav">';
						echo '<li><a  href="Inscription.php"> Inscrire un nouvel utilisateur </a></li>';
						echo '<li><a  href="CreationSujet.php"> Créer Sujet </a></li>';
						echo '<li><a  href="CreationCategorie.php"> Créer Catégorie </a></li>';
						echo '</ul>';
						echo '<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>';
					}
					else //Si c'est un simple utilisateur
					{
						echo '<ul class="nav navbar-nav">';
						echo '<li><a  href="CreationSujet.php"> Créer Sujet </a></li>';
						echo '</ul>';
						echo '<a class="btn btn-primary navbar-btn navbar-right" href="Deconnexion.php"> Deconnexion </a>';
					}

				}
			?> 
	        </div>
	      </div>
    </nav>
		
		<?php 
			// Rencontre-t-on une erreur ?
			if(!empty($errorMessage)) echo '<p class="alert alert-danger" role="alert" >', htmlspecialchars($errorMessage) ,'</p>';
		?>
		<section class="container"> <!-- Section centrale -->
			<header>
				<h1> Bienvenue sur le forum !! </h1>
			</header>
		<ul>
			<?php
				/*if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
				{
					if(($_SESSION['admin']) == '1') //Si la personne qui est connecté est pas un administrateur alors elle peut accéder à la création de catégorie
					{
						echo '<li><a class="btn btn-primary" href="Inscription.php">Inscrire un nouvel utilisateur </a></li>';
					}
				}
		
				if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
				{
					echo '<li><a class="btn btn-primary" href="CreationSujet.php">Créer Sujet </a></li>	';
				}
				
				if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
				{
					if(($_SESSION['admin']) == '1') //Si la personne qui est connecté est pas un administrateur alors elle peut accéder à la création de catégorie
					{
						echo '<li><a class="btn btn-primary" href="CreationCategorie.php">Créer Catégorie </a></li>	';
					}
				}*/
			?>		
		</ul>
		<?php 
		for($i = 0 ; $i<count($categorie); $i++)
		{
			$test = $categorie[$i]['cid'];
			$select = ("SELECT titre , description , cid FROM sujet WHERE cid=".$test.""); //  Récupération des sujet dans la BDD
			$statement = $pdo->query($select);
			$sujet = $statement->fetchAll(PDO::FETCH_ASSOC);
			echo '<section  class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" >'.$categorie[$i]['titre'].'</h3>
						</div>
							<p class="panel-body">'.$categorie[$i]['description'].'</p>
										<ul class="">';
			
			/*for($j = 0 ; $j<count($sujet) ; $j++)
			{
				
							echo '<li> '.$sujet[$j]['titre'].':'.$sujet[$j]['description'].'  </li>';				
			}*/
			
			echo						'</ul>
				 </section>';
		}
		?>
		</section>
	</body>
	<footer >
	</footer>
</html>