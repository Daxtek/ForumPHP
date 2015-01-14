<h3> Bienvenue sur le sujet <?= $sujet[0]['titre']?> </h3>
<!-- Affichage des sujets -->
<section  class="panel panel-primary"> 
	<div class="panel-heading">
		<h1 class="panel-title" ><?= $sujet[0]['titre']?></h1>
	</div>
	<ul class="list-group">
		<!--Mettre les posts ici -->
		<?php foreach ($posts as $postsKey => $post): ?>
			<li class="list-group-item">
				<h4><?= $post['pseudo'] ?> posté le <?= $post['date_creation'] ?></h4>
				<p><?= $post['texte'] ?></p>
				<?php if (isset($_SESSION['utilisateur_id']) && ($_SESSION['utilisateur_id'] == $post['utilisateur_id'] || $_SESSION['admin'])): ?>
					<a class="btn btn-xs btn-default" href="modif_post.php?pid=<?= $post['post_id'] ?>">Modifier</a>
					<?php if ($sujet[0]['premier_post'] != $post['post_id']): ?>
						<a class="btn btn-xs btn-default" href="suppr_post.php?pid=<?= $post['post_id'] ?>">Supprimer</a>
					<?php endif ?>
				<?php endif ?>
			</li>			
		<?php endforeach ?>

		<li class="list-group-item"> <!-- Section du formulaire de nouveau post -->
			<h4>Répondre :</h4>
			<?php if (isset($_SESSION['utilisateur_id'])): ?>
				<form  name="formPost" action="" method="POST" onsubmit="return verifForm()">
					<div class="row">	
						<div class="form-group col-lg-8 col-md-8">
							<textarea class="form-control"  id="idtexte" name="texte" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"></textarea><br>
						</div>
					</div>
					<input class="btn btn-default" type="submit" value="Valider">
					<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
				</form>	
			<?php else: ?>
				<p class="alert alert-info">Connectez-vous pour répondre</p>
			<?php endif ?>
		</li>
		<?php if(!empty($messageCreation)): ?><!-- Message du succès de la création --> 
			<p class="alert alert-success"><?=  htmlspecialchars($messageCreation) ?> </p>
		<?php endif; ?>	
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
