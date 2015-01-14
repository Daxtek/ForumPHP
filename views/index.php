<header>
	<h1> Bienvenue sur le forum !! </h1>
</header>

<?php foreach ($forum as $categorieKey => $categorie): ?>
	<!-- Affichage des catégories -->
	<section  class="panel panel-primary"> 
		<div class="panel-heading">
			<h1 class="panel-title" ><?= $categorie['titre']?></h1>
		</div>
		<div class="panel-body">
			
			<p ><?= $categorie['description']?></p>
			<ul class="list-group">
				<!-- Affichage des sujets -->
				<?php foreach ($categorie['sujets'] as $sujetKey => $sujet): ?>
						<?php if ($sujet['ouvert'] == '1' ):?> <!-- Si le sujet est ouvert -->
							<a href="sujet.php?sid=<?= $sujet['sujet_id'] ?>" class="list-group-item">
							<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1'): ?> <!-- Si l'utilisateur est connecté et que c'est un administrateur -->
								<form class="inline"  name="formFermetureSujet" action="" method="POST" >
									<div class="inline form-group">
										<input type="hidden" name="SujetAFermeID" value="<?= $sujet['sujet_id']?>" required>
										<button type="submit" class="glyphicon glyphicon-lock" title="Fermer le sujet"  > </button>
									</div>
								</form> 
								<form class="inline" name="formSuppression" action="./suppr_sujet.php?sid=<?= $sujet['sujet_id'] ?>" method="POST">
									<button type="submit" name="suppr" title="Supprimer le sujet" class="glyphicon glyphicon-trash" value=<?=$sujet["sujet_id"] ?> > </button>
								</form>	
							<?php elseif(isset ($_SESSION['utilisateur_id']) && $sujet['utilisateur_id'] == $_SESSION['utilisateur_id']):?>
								<form class="inline" name="formSuppression" action="./suppr_sujet.php?sid=<?= $sujet['sujet_id'] ?>" method="POST">
									<button type="submit" name="suppr" title="Supprimer le sujet" class="glyphicon glyphicon-trash" value=<?=$sujet["sujet_id"] ?> > </button>
								</form>		
							<?php endif;?>
								<h4><?= $sujet['titre']?> : </h4>
								<p><?= $sujet['dernier_post']['texte']?></p> 
							</a>
						<?php elseif ($sujet['ouvert'] == '0'):?> <!-- Si le sujet est fermé  -->
							<li class="list-group-item  disabled"> 
							<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1'): ?> <!-- Si l'utilisateur est connecté et que c'est un administrateur -->
								<form class="inline" name="formOuvertureSujet" action="" method="POST">	
									<div class="inline form-group ">
										<input type="hidden" name="SujetAReouvrirID" value="<?= $sujet['sujet_id']?>" required>
										<button type="submit" class="glyphicon glyphicon-ok" title="Réouvrir le sujet">  </button> 
									</div>	
								</form>
								<form class="inline" name="formSuppression" action="./suppr_sujet.php?sid=<?= $sujet['sujet_id'] ?>" method="POST">
									<button type="submit" name="suppr" title="Supprimer le sujet" class="glyphicon glyphicon-trash" value=<?=$sujet["sujet_id"] ?> > </button>
								</form>	
							<?php elseif(isset ($_SESSION['utilisateur_id']) && $sujet['utilisateur_id'] == $_SESSION['utilisateur_id']):?>
								<form class="inline" name="formSuppression" action="./suppr_sujet.php?sid=<?= $sujet['sujet_id'] ?>" method="POST">
									<button type="submit" name="suppr" title="Supprimer le sujet" class="glyphicon glyphicon-trash" value=<?=$sujet["sujet_id"] ?> > </button>
								</form>	
							<?php endif;?>
								<h4><?= $sujet['titre']?> :</h4>
								<p> <?= $sujet['dernier_post']['texte']?></p> <!-- Afficher le dernier post --> 		
							</li>
						<?php endif;?>
				<?php endforeach ?>
			</ul>
			<?php if (isset($_SESSION['utilisateur_id']) && !empty($_SESSION['utilisateur_id']) ): ?> <!-- Si on est un utilisateur alors on affiche le lien vers la création de sujet -->
				<a class="btn btn-default col-lg-3"  href="creation_sujet.php?cid=<?= $categorie['categorie_id'] ?>"> Créer un nouveau sujet </a> <!-- Lien vers la création de sujet -->
			<?php endif;?>
		</div>
	 </section>
<?php endforeach ?>