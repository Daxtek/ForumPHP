<?php

require('init-page.php');

//Initialisation des variables
$messageModification ='';
$faute = false;

if(isset($_SESSION['utilisateur_id']) && !empty($_SESSION['utilisateur_id']))
{
	
	$user = $Requests->getUser($_SESSION['utilisateur_id']);
	
	
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
			
			if ($pseudo != $user[0]['pseudo'] ) //Si le pseudo a été modifié
			{
				//Vérification de l'existence du pseudonyme
				if ($Requests->userExist($pseudo)) {
					$errorMessage .= "Le pseudonyme que vous avez choisi existe déjà.\n"; // message d'erreur
					$faute = true;
				}
			}
			
			if ($mail != $user[0]['mail'] ) //Si le mail a été modifié
			{
				//Vérification de l'existence du mail
				if ($Requests->mailExist($mail))
				{
					$errorMessage .= "Le mail que vous avez choisi existe déjà.\n";
					$faute = true;
				}
			}
			
			if ($mdp != $user[0]['mdp'] ) //Si le mot de passe a été modifié
			{
				//Vérification du mot de passe
				if ( $mdp != $mdpConfirmation)
				{
					$errorMessage .= "Les mots de passe ne correspondent pas.\n";
					$faute=true;
				}
			}
			
			//Si l'ensemble des données sont correctes on modifie les données du membre dans la table utilisateur
			if(!$faute)
			{
				//Insertion des données de l'utilisateur dans la base
				if ($Requests->updateUser($pseudo, $mdp, $mail, $nom, $prenom, $_SESSION['utilisateur_id'])) {
					
						$messageModification ='Votre profil a bien été modifié '. $pseudo;
						header('Location: ./profil.php'); //Actualisation de la page profil
				}
				else
					$errorMessage .= "Une erreur est survenu lors de la modification ...";
			}
			
		}
	}
	
	
	
	$titlePage = 'Profil';
	
	include 'views/template/header.php';
	include 'views/profil.php';
	include 'views/template/footer.php';
}
else 
{
	header('Location: ./'); //Redirection vers la page d'accueil
}



?>