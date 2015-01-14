<?php

//connexion db
require("connexion.php");

class Requests {

	protected $pdo;

	public function Requests($pdo) {
		$this->pdo = $pdo;
	}




	//===================
	// === CATÉGORIES ===
	//===================


	public function categorieExist($categorie_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE categorie_id=:categorie_id');
		$stmt->bindParam(':categorie_id', $categorie_id);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function getAllCategories() {
		$stmt = $this->pdo->prepare('SELECT * FROM categorie');
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCategoriesAndSujets() {
		$categories = $this->getAllCategories();
		foreach ($categories as $categorieKey => $categorie) {
			$categories[$categorieKey]['sujets'] = $this->getSujetsByCategorie($categorie['categorie_id']);

			foreach ($categories[$categorieKey]['sujets'] as $sujetKey => $sujet) {
				$categories[$categorieKey]['sujets'][$sujetKey]['dernier_post'] = $this->getPost($sujet['dernier_post']);
			}
		}

		return $categories;
	}
	

	public function titreCategorieExist($titre) {
		$stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE titre=:titre');
		$stmt->bindParam(':titre', $titre);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function addCategorie($titre, $utilisateur_id, $description) {
		$stmt = $this->pdo->prepare('
			INSERT INTO categorie (titre, utilisateur_id, date_creation, description)
			VALUES (:titre, :utilisateur_id, NOW(), :description)
		');
		$stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':utilisateur_id', $utilisateur_id);
		$stmt->bindParam(':description', $description);

		return $stmt->execute();
	}




	//===============
	// === SUJETS ===
	//===============


	public function sujetExist($sujet_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':sujet_id', $sujet_id);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function getSujetsByCategorie($categorie_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE categorie_id=:categorie_id ORDER BY date_creation');
		$stmt->bindParam(':categorie_id', $categorie_id);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getSujet($sujet_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':sujet_id', $sujet_id);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function titreSujetExist($titre, $categorie_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE titre=:titre AND categorie_id=:categorie_id');
		$stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':categorie_id', $categorie_id);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	
	public function addSujet($categorie_id, $utilisateur_id, $titre, $texte)
	{
		try {
			$this->pdo->beginTransaction();

			$stmt= $this->pdo->prepare('
				INSERT INTO sujet (categorie_id, utilisateur_id, date_creation, titre, ouvert)
				VALUES (:categorie_id, :utilisateur_id, NOW(), :titre, 1)
			');
			$stmt->bindParam(':categorie_id', $categorie_id);
			$stmt->bindParam(':utilisateur_id', $utilisateur_id);
			$stmt->bindParam(':titre', $titre);
			$stmt->execute();

			$sujet_id = $this->sujetLastId();
			$this->addPost($sujet_id, $utilisateur_id, $texte);

			$this->pdo->commit();

			return true;
		} catch (Exception $e) {
			$this->pdo->rollBack();

			return false;
		}
	}

	public function deleteSujet($sujet_id) {
		// Comme il y a plusieurs requêtes pour supprimer un sujet on commence une transaction (pour annuler l'auto-commit) et on la valide ou non si il y a des erreurs
		try {
			$this->pdo->beginTransaction();

			$stmt = $this->pdo->prepare('DELETE FROM post WHERE sujet_id=:sujet_id');
			$stmt->bindParam(':sujet_id', $sujet_id);
			$stmt->execute();

			$stmt = $this->pdo->prepare('DELETE FROM sujet WHERE sujet_id=:sujet_id');
			$stmt->bindParam(':sujet_id', $sujet_id);
			$stmt->execute();

			$this->pdo->commit();

			return true;
		}
		catch (Exception $e) {
			$this->pdo->rollBack();

			return false;
		}
	}
	
	//Récupère l'id du dernier sujet ajouter dans la table sujet
	public function sujetLastId() {
		$stmt = $this->pdo->prepare('
			SELECT sujet_id FROM sujet ORDER BY sujet_id DESC LIMIT 1
		');
		//Si la requête est fausse, la suite de la fonction est annulé
		
		if(!$stmt->execute())
			return false;
		$lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $lastID[0]['sujet_id'];
	}
	
	public function closeSubject($sujet_id) {
		$stmt = $this->pdo->prepare('UPDATE sujet SET ouvert=0, date_fermeture=NOW() WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':sujet_id', $sujet_id);

		return $stmt->execute();
	}
	
	public function openSubject($sujet_id) {
		$stmt = $this->pdo->prepare('UPDATE sujet SET ouvert=1 WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':sujet_id', $sujet_id);
	
		return $stmt->execute();
	
	}
	
	//Met a jour le premier dans la table sujet
	public function updateFirstPost($post_id, $sujet_id)
	{
		$stmt = $this->pdo->prepare('UPDATE sujet SET premier_post=:post_id WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':post_id', $post_id);
		$stmt->bindParam(':sujet_id', $sujet_id);
	
		return $stmt->execute();
	}
	
	//Met a jour le dernier dans la table sujet
	public function updateLastPost($post_id, $sujet_id)
	{
		$stmt = $this->pdo->prepare('UPDATE sujet SET dernier_post=:post_id WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':post_id', $post_id);
		$stmt->bindParam(':sujet_id', $sujet_id);
	
		return $stmt->execute();
	}
	
	//Met a jour le premier et le dernier_post dans la table sujet avec le même identifiant de post, fait pour la création du sujet
	public function updateLastAndFirstPost($post_id, $sujet_id)
	{
		$stmt = $this->pdo->prepare('UPDATE sujet SET premier_post=:post_id, dernier_post=:post_id WHERE sujet_id=:sujet_id');
		$stmt->bindParam(':post_id', $post_id);
		$stmt->bindParam(':sujet_id', $sujet_id);
	
		return $stmt->execute();
	}




	//=============
	// === USER ===
	//=============


	public function getUser($utilisateur_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE utilisateur_id=:utilisateur_id');
		$stmt->bindParam(':utilisateur_id', $utilisateur_id);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function userConnect($pseudo, $mdp) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo=:pseudo AND mdp=:mdp LIMIT 1');
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->bindParam(':mdp', $mdp);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($res))
			return false;		
		else
			return $res[0];
	}

	public function userExist($pseudo) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo=:pseudo');
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function mailExist($mail) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE mail=:mail');
		$stmt->bindParam(':mail', $mail);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function addUser($pseudo, $mdp, $mail, $nom, $prenom) {
		$stmt = $this->pdo->prepare('
			INSERT INTO utilisateur (pseudo, mdp, mail, date_inscription, nb_posts, admin, nom, prenom)
			VALUES (:pseudo, :mdp, :mail, NOW(), 0, 0, :nom, :prenom)
		');
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->bindParam(':mdp', $mdp);
		$stmt->bindParam(':mail', $mail);
		$stmt->bindParam(':nom', $nom);
		$stmt->bindParam(':prenom', $prenom);

		return $stmt->execute();
	}
	



	//===============
	// ==== POST ====
	//===============


	public function postExist($post_id) {
		$stmt = $this->pdo->prepare('SELECT * FROM post WHERE post_id=:post_id');
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function getPost($post_id) {
		$stmt = $this->pdo->prepare('
			SELECT post_id, utilisateur_id, sujet_id, date_creation, texte, pseudo FROM post
			NATURAL JOIN utilisateur
			WHERE post_id=:post_id
		');
		$stmt->bindParam(':post_id', $post_id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($res))
			return false;
		else
			return $res[0];
	}

	public function getPostsBySubject($sujet_id) {
		$stmt = $this->pdo->prepare('
			SELECT post_id, utilisateur_id, sujet_id, date_creation, texte, pseudo FROM post
			NATURAL JOIN utilisateur
			WHERE sujet_id=:sujet_id
			ORDER BY date_creation
		');
		$stmt->bindParam(':sujet_id', $sujet_id);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function addPost($sujet_id, $utilisateur_id, $texte) {
		try {
			$this->pdo->beginTransaction();

			$stmt = $this->pdo->prepare('
				INSERT INTO post (sujet_id, utilisateur_id , date_creation, texte)
				VALUES (:sujet_id, :utilisateur_id, NOW(), :texte)
			');
			$stmt->bindParam(':sujet_id', $sujet_id);
			$stmt->bindParam(':utilisateur_id', $utilisateur_id);
			$stmt->bindParam(':texte', $texte);
			$stmt->execute();

			$post_id = $this->postLastId();
			$stmt = $this->pdo->prepare('UPDATE sujet SET dernier_post=:post_id WHERE sujet_id=:sujet_id');
			$stmt->bindParam(':post_id', $post_id);
			$stmt->bindParam(':sujet_id', $sujet_id);
			$stmt->execute();

			$this->pdo->commit();

			return true;
		}
		catch (Exception $e) {
			$this->pdo->rollBack();

			return false;
		}
	}

	public function deletePost($post_id) {
		$stmt = $this->pdo->prepare('DELETE FROM post WHERE post_id=:post_id');
		$stmt->bindParam(':post_id', $post_id);

		return $stmt->execute();
	}

	public function updatePost($post_id, $texte) {
		$stmt = $this->pdo->prepare('UPDATE post SET `texte`=:texte WHERE post_id=:post_id');
		$stmt->bindParam(':texte', $texte);
		$stmt->bindParam(':post_id', $post_id);

		return $stmt->execute();
	}
	
	//Récupère l'id du dernier_post ajouter dans la table post
	public function postLastId() {
		$stmt = $this->pdo->prepare('
			SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1
		');
		//Exécute la requête
		if(!$stmt->execute())//Si la requête est fausse, la suite de la fonction est annulé
			return false;
		
		$lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $lastID[0]['post_id'];
	}
}

$Requests = new Requests(connect_bd());
