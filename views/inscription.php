			<header>
				<h1> Formulaire d'inscription</h1>
			</header>
			<form name="formInscription" action="#" method="POST" onsubmit="return verifForm()">
				
				<label for="idnom"> Nom : </label><input class="form-control" type="text" id="idnom" name="nom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un nom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
				<label for="idprenom"> Prénom : </label><input class="form-control" type="text" id="idprenom" name="prenom" size="20" maxlength="100" pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{2,}" title="Veuillez renter un prénom contenant uniquement des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" required > <br>
				<label for="idemail"> Email : </label><input class="form-control" type="email" id="idemail" name="email" maxlength="100" pattern="[0-9a-z-._]+@[a-z]+[.]+[a-z]{2,3}" title="Veuillez rentrez un email valide" required ><br>
				<label for="idmdp"> Mot de passe : </label><input class="form-control" type="password" id="idmdp" name="mdp" required ><br>
				<label for="idmdpConfirmation"> Confirmer le mot de passe : </label><input class="form-control" type="password"  id="idmdpConfirmation" name="mdpConfirmation" required title="Les deux champs doivent correspondre" ><br>
				<label for="idpseudo"> Pseudonyme : </label><input class="form-control" type="text" id="idpseudo" name="pseudo" size="20" maxlength="20" required pattern="[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789]{2,}" title="Le pseudonyme peut contenir des chiffres et des caractères alphabétiques ( accents autorisés), taille minimum 2 caractères" ><br>
				
				<input class="btn btn-default" type="submit" value="Valider">
				<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
			</form>
			<!-- Messages d'alerte -->
			<?php if(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
				<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
			<?php endif;?>


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