<?php

//connexion db
require("connexion.php");

class Requests {

	protected $pdo;

	public function Requests($pdo) {
		$this->pdo = $pdo;
	}

	// === CATÉGORIES ===
	public function categorieExist($cid) {
		$stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE cid=:cid');
		$stmt->bindParam(':cid', $cid);
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
		foreach ($categories as $key => $categorie) {
			$categories[$key]['sujets'] = $this->getSujetsByCategorie($categorie['cid']);
		}

		return $categories;
	}

	public function titreCategorieExist($titre) {
		$stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE Titre=:titre');
		$stmt->bindParam(':titre', $titre);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function addCategorie($titre, $uid, $description) {
		$stmt = $this->pdo->prepare('
			INSERT INTO categorie (Titre, uid, `date de creation`, Description)
			VALUES (:titre, :uid, NOW(), :description)
		');
		$stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':uid', $uid);
		$stmt->bindParam(':description', $description);

		return $stmt->execute();
	}

	// === SUJETS ===
	public function getSujetsByCategorie($cid) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE cid=:cid');
		$stmt->bindParam(':cid', $cid);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getSujet($sid) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE sid=:sid');
		$stmt->bindParam(':sid', $sid);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function titreSujetExist($titre, $cid) {
		$stmt = $this->pdo->prepare('SELECT * FROM sujet WHERE Titre=:titre AND cid=:cid');
		$stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':cid', $cid);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function addSujet($cid, $uid, $description, $titre) {
		$stmt = $this->pdo->prepare('
			INSERT INTO sujet (cid, uid, `Date de creation`, Description, Titre, Statut)
			VALUES (:cid, :uid, NOW(), :description, :titre, 1)
		');
		$stmt->bindParam(':cid', $cid);
		$stmt->bindParam(':uid', $uid);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':titre', $titre);

		return $stmt->execute();
	}
	
	public function closeSubject($sid) {
		$stmt = $this->pdo->prepare('UPDATE sujet SET statut=0,`Date de fermeture`=NOW() WHERE sid=:sid');
		$stmt->bindParam(':sid', $sid);

		return $stmt->execute();
		
		
	
	}
	
	public function openSubject($sid) {
		$stmt = $this->pdo->prepare('UPDATE sujet SET statut=1 WHERE sid=:sid');
		$stmt->bindParam(':sid', $sid);
	
		return $stmt->execute();
	
	}

	// === USER ===
	public function getUser($uid) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE uid=:uid');
		$stmt->bindParam(':uid', $uid);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function userConnect($pseudo, $mdp) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE Pseudonyme=:pseudo AND `Mot de passe`=:mdp LIMIT 1');
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
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE Pseudonyme=:pseudo');
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function mailExist($mail) {
		$stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE Mail=:mail');
		$stmt->bindParam(':mail', $mail);
		$stmt->execute();

		return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	public function addUser($pseudo, $mdp, $mail, $nom, $prenom) {
		$stmt = $this->pdo->prepare('
			INSERT INTO utilisateur (Pseudonyme, `Mot de passe`, Mail, `Date d\'inscription`, `Nombre de post`, Administrateur, Nom, Prenom)
			VALUES (:pseudo, :mdp, :mail, NOW(), 0, 0, :nom, :prenom)
		');
		$stmt->bindParam(':pseudo', $pseudo);
		$stmt->bindParam(':mdp', $mdp);
		$stmt->bindParam(':mail', $mail);
		$stmt->bindParam(':nom', $nom);
		$stmt->bindParam(':prenom', $prenom);

		return $stmt->execute();
	}
	
	// ==== POST ====
	public function getPostsBySubject($sid) {
		$stmt = $this->pdo->prepare('SELECT * FROM post WHERE sid=:sid');
		$stmt->bindParam(':sid', $sid);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function addPost($sid, $cid, $uid, $titre, $texte) {
		$stmt = $this->pdo->prepare('
			INSERT INTO post (sid, cid, uid , Titre, `date de creation`, Texte)
			VALUES (:sid, :cid, :uid, :titre, NOW(), :texte)
		');
		$stmt->bindParam(':sid', $sid);
		$stmt->bindParam(':cid', $cid);
		$stmt->bindParam(':uid', $uid);
		$stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':texte', $texte);
	
		return $stmt->execute();
	}
	
}

$Requests = new Requests(connect_bd());