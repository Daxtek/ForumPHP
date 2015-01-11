		<header>
			<h1> Formulaire de création de sujet</h1>
		</header>
		<form  name="formSujet" action="#" method="POST" onsubmit="return verifForm()">
			<label  for="idtitre"> Titre : </label><input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required ><br>
			<label  for="iddescrip"> Description : </label><textarea class="form-control"  id="iddescrip" name="description" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
			<label  for="iddescrip"> Catégorie : </label>
			<select class="form-control" name="categorie">
				<option value="select"> Sélectionnez la catégorie à laquelle le sujet appartient </option>  <!-- Affiche les différents choix possible à l'aide d'une boucle  -->
				<?php foreach ($categories as $key => $categorie): ?>
					<option value=<?= $categorie['cid']?>><?=  $categorie['Titre'] ?> </option> 
				 <?php endforeach ?>
			</select>
			<br>
			
			<input class="btn btn-default" type="submit" value="Valider">
			<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
		</form>
		<?php if(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
			<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
		<?php endif;?>

		<script>
			/* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
			function verifForm()
			{
				titre = document.formCreation.titre.value;
				
				var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
				if (!reg.test(titre)) 
				{	
					alert("le titre n'est pas valide");
					return false; //Empeche le submit si les vérifications ne sont pas valides
				}
			}
		</script>