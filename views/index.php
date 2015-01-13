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
					<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1'): ?> <!-- Si l'utilisateur est connecté et que c'est un administrateur -->
						<?php if ($sujet['Statut']== '1' ):?> <!-- Si le sujet est ouvert -->
							<a href="Sujet.php?sid=<?= $sujet['sujet_id'] ?>" class="list-group-item col-lg-10"> 
								<h4><?= $sujet['titre']?> :</h4>
								<p><?= $sujet['dernier_post']['texte']?></p> <!-- Afficher le dernier post -->
							</a>
							<form name="formFermetureSujet" action="#" method="POST" >
								<div class="form-group col-lg-2">
									<input type="hidden" name="SujetAFermeID" value="<?= $sujet['sujet_id']?>" required>
									<button type="submit" class="btn btn-warning"> Fermez le sujet </button>
								</div>
							</form> 
						<?php elseif ($sujet['ouvert']== '0' ):?> <!-- Si le sujet est fermé  -->
							<li class="list-group-item col-lg-10 disabled"> 
								<h4><?= $sujet['titre']?> :</h4>
								<p> <?= $sujet['dernier_post']['texte']?></p> <!-- Afficher le dernier post --> 		
							</li>
							<form name="formOuvertureSujet" action="#" method="POST">	
								<div class="form-group col-lg-2">
									<input type="hidden" name="SujetAReouvrirID" value="<?= $sujet['sujet_id']?>" required>
									<button type="submit" class="btn btn-warning"> Réouvrir le sujet </button> 
								</div>
							</form>		
						<?php endif;?>
					<?php else:?> 
						<?php if ($sujet['ouvert']== '1' ):?> <!-- Si le sujet est ouvert -->
							<a href="Sujet.php?sid=<?= $sujet['sujet_id'] ?>" class="list-group-item "> 
								<h4><?= $sujet['titre']?> :</h4>
								<p> <?= $sujet['dernier_post post']['texte']?> </p> <!-- Afficher le dernier post -->
							</a>
						<?php elseif ($sujet['ouvert']== '0' ):?> <!-- Si le sujet est fermé -->
							<li class="list-group-item disabled" > 
								<h4><?= $sujet['titre']?> :</h4>
								<p> <?= $sujet['dernier_post post']['texte']?></p> <!-- Afficher le dernier post -->	
							</li>
						<?php endif;?>
					<?php endif;?>
				<?php endforeach ?>
			</ul>
			<?php if (isset($_SESSION['uid']) && !empty($_SESSION['uid']) ): ?> <!-- Si on est un utilisateur alors on affiche le lien vers la création de sujet -->
				<a class="btn btn-default col-lg-3"  href="CreationSujet.php?cid=<?= $categorie['cid'] ?>"> Créer un nouveau sujet </a> <!-- Lien vers la création de sujet -->
			<?php endif;?>
		</div>
	 </section>
<?php endforeach ?>