
<header>
	<h2> Bienvenue sur votre profil <?= $user[0]['pseudo']?> </h2>
</header>

<section class="container "> <!-- Section de la table -->
	<table class="table table-condensed">
	<?php foreach ($user as $utilisateurKey => $utilisateur): ?>
		<tr> <td> Pseudonyme  :</td><td> <?= $utilisateur['pseudo']?> </td></tr>
		<tr> <td> Mail  :</td><td> <?= $utilisateur['mail']?> </td></tr>
		<tr> <td> Date d'inscription  :</td><td> <?= $utilisateur['date_inscription']?> </td></tr>
		<tr> <td> Nom  :</td><td> <?= $utilisateur['nom']?> </td></tr>
		<tr> <td> Prenom  :</td><td> <?= $utilisateur['prenom']?> </td></tr>
		<tr> <td> Nombre de posts :</td><td> <?= $utilisateur['nb_posts']?> </td></tr>
	<?php endforeach;?>
	</table>
</section>

<!-- Messages d'alerte -->
<?php if(!empty($messageModification)): ?><!-- Message du succès de la création --> 
		<p class="alert alert-success"><?=  htmlspecialchars($messageModification) ?> </p>
<?php endif;?>

<h3> Editer votre profil</h3>
<section class="container "> <!-- Section de l'édition -->
	<form name="formEdition" action="" method="POST">
	
		<label for="idnom"> Nom : </label><input class="form-control" value="<?= $utilisateur['nom']?>" type="text" id="idnom" name="nom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un nom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required> <br>
		<label for="idprenom"> Prénom : </label><input class="form-control" value="<?= $utilisateur['prenom']?>" type="text" id="idprenom" name="prenom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un prénom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required  > <br>
		<label for="idemail"> Email : </label><input class="form-control" value="<?= $utilisateur['mail']?>" type="email" id="idemail" name="email" maxlength="100" pattern="[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}" title="Veuillez rentrez un email valide" required  ><br>
		<label for="idmdp"> Mot de passe : </label><input class="form-control" value="<?= $utilisateur['mdp']?>" type="password" id="idmdp" name="mdp" required ><br>
		<label for="idmdpConfirmation"> Confirmer le mot de passe : </label><input class="form-control" value="<?= $utilisateur['mdp']?>" type="password"  id="idmdpConfirmation" name="mdpConfirmation" required title="Les deux champs doivent correspondre" required><br>
		<label for="idpseudo"> Pseudonyme : </label><input class="form-control" value="<?= $utilisateur['pseudo']?>" type="text" id="idpseudo" name="pseudo" size="20" maxlength="20" required pattern="[a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ]{2,}" title="Le pseudonyme peut contenir des chiffres et des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères"  required><br>
					
		<input class="btn btn-default" type="submit" value="Valider">
		<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
	
	</form>
</section>
<script type="text/javascript">

/* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
	function verifForm()
	{
		nom = document.formEdition.nom.value;
		prenom = document.formEdition.prenom.value;
		mail = document.formEdition.email.value;
		pseudo = document.formEdition.pseudo.value;
					
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
		var reg = new RegExp("^[a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
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