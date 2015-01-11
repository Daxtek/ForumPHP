<h3> Bienvenue sur le sujet <?= $sujet[0]['Titre']?> </h3>
<!-- Affichage des sujets -->
<section  class="panel panel-primary"> 
	<div class="panel-heading">
		<h1 class="panel-title" ><?= $sujet[0]['Titre']?></h1>
	</div>
	<p class="panel-body"><?= $sujet[0]['Description']?></p>
	<ul class="list-group">
		<!--Mettre les posts ici -->
		<?php for($j = 0 ; $j<count($post) ; $j++) :?>
			<li href="#" class="list-group-item"> <h4><?= $post[$j]['Titre']?> :</h4><p> <?= $post[$j]['Texte'] ?></p> </li>			
		<?php endfor;?>
		<section class="container"> <!-- Section du formulaire de nouveau post -->
			<h4>Répondre :</h4>
			<form  name="formPost" action="#" method="POST" onsubmit="return verifForm()">
				<div class="row">
					<div class="form-group col-lg-3 col-md-3">
						<label  for="idtitre"> Titre : </label>
						<input class="form-control" type="text" id="idtitre" name="titre" size="20" maxlength="50" pattern="[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}" title="Veuillez renter un titre commencent par une majuscule, taille minimum 3 caractères" required ><br>
					</div>		
					<div class="form-group col-lg-8 col-md-8">	
						<label  for="idtexte"> Texte : </label>
						<textarea class="form-control"  id="idtexte" name="texte" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
					</div>
				</div>
				<input class="btn btn-default" type="submit" value="Valider">
				<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
			</form>	
		</section>
		<?php if(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
			<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
		<?php endif;?>	
	</ul>
</section>
<script>
	  /* Cette fonction sert de sécurité au cas où la vérification du pattern ne fonctionne pas */
	function verifForm()
	{
		titre = document.formPost.titre.value;
		
		var reg = new RegExp("^[A-Z]+[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ123456789 ]{2,}$"); /* Pour les accents on est obligés de tous les préciser un par un */
		if (!reg.test(titre)) 
		{	
			alert("le titre n'est pas valide");
			return false; //Empeche le submit si les vérifications ne sont pas valides
		}
	}
</script>