
<?php

require('init-page.php');

if(isset($_SESSION['admin'])) //Si la variable de session a été créer ( si la personne est connectée au site )
{
	if(($_SESSION['admin']) == '0') //Si la personne qui est connecté n'est pas un administrateur alors elle ne peut pas créer d'autres comptes
	{
		header('Location: ./Index.php'); //Redirection vers la page d'accueil
	}
}

//Initialisation des variables
$messageInscription ='';
$faute = false;

//Vérification du formulaire une fois que celui-ci est rempli
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (
		isset($_POST['nom']) &&
		!empty( $_POST['nom']) &&
		isset($_POST['prenom']) &&
		!empty( $_POST['prenom']) &&
		isset($_POST['email']) &&
		!empty( $_POST['email']) &&
		isset($_POST['pseudo']) &&
		!empty( $_POST['pseudo']) &&
		isset($_POST['mdp']) &&
		!empty( $_POST['mdp']) &&
		isset($_POST['mdpConfirmation']) &&
		!empty( $_POST['mdpConfirmation'])
	) { // Uniquement $nom car tous les champs sont requis ( required ) 

		//Récupération des données du formulaire
		$nom=($_POST ['nom']);
		$prenom=( $_POST ['prenom']);
		$mail=( $_POST ['email']);
		$pseudo=( $_POST ['pseudo']);
		$mdp=( $_POST ['mdp']);
		$mdpConfirmation=( $_POST ['mdpConfirmation']);
	
	//Vérification de l'existence du pseudonyme
		if ($Requests->userExist($pseudo)) {
			$errorMessage .= "Le pseudonyme que vous avez choisi existe déjà.\n"; // message d'erreur
			$faute = true;
		}

		
	//Vérification de l'existence du mail
		if ($Requests->mailExist($mail))
		{
			$errorMessage .= "Le mail que vous avez choisi existe déjà.\n";
			$faute = true;
		}
		
	//Vérification du mot de passe	
		if ( $mdp != $mdpConfirmation)
		{
			$errorMessage .= "Les mots de passe ne correspondent pas.\n";
			$faute=true;
		}		
		
	//Si l'ensemble des données sont correctes on ajoute le nouveau membre dans la table utilisateur
		if(!$faute)
		{
			//Insertion des données de l'utilisateur dans la base
			if ($Requests->addUser($pseudo, $mdp, $mail, $nom, $prenom)) {
				//Personnalisation du message en fonction de si l'utilisateur est un administrateur ou non
				if(isset($_SESSION['admin']))
					$messageInscription ='Vous avez inscrit l\'utilisateur ' . $pseudo  ;
				else
					$messageInscription ='Vous êtes inscrit '. $pseudo;
			}

			else
				$errorMessage .= "Une erreur est survenu lors de l'enregistrement...";
		}
	} 
}

$titlePage = 'Inscription';

include 'views/template/header.php';
include 'views/inscription.php';
include 'views/template/footer.php';
