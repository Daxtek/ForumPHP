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
			<li href="#" class="list-group-item">
				<h4>Réponse</h4>
				<p><?= $post[$j]['Texte'] ?></p>
				<?php if ($_SESSION['uid'] == $post[$j]['uid'] || $_SESSION['admin']): ?>
					<a class="btn btn-xs btn-default" href="modif_post.php?pid=<?= $post[$j]['pid'] ?>">Modifier</a>
					<a class="btn btn-xs btn-default" href="suppr_post.php?pid=<?= $post[$j]['pid'] ?>">Supprimer</a>
				<?php endif ?>
			</li>			
		<?php endfor;?>
		
		
		<section class="container"> <!-- Section du formulaire de nouveau post -->
			<h4>Répondre :</h4>
			<?php include 'views/forms/formPost.php'; ?>
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