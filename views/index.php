<header>
	<h1> Bienvenue sur le forum !! </h1>
</header>

<?php foreach ($forum as $categorieKey => $categorie): ?>
	<!-- Affichage des catégories -->
	<section  class="panel panel-primary"> 
		<div class="panel-heading">
			<h1 class="panel-title" ><?= $categorie['Titre']?></h1>
		</div>
		<p class="panel-body"><?= $categorie['Description']?></p>
		<ul class="list-group">
			<!-- Affichage des sujets, premier jets -->
			<?php foreach ($categorie['sujets'] as $sujetKey => $sujet): ?>
				<?php if ($sujet['Statut']== '1'): ?> <!-- Si le sujet est ouvert -->
					<a href="Sujet.php?sid=<?= $sujet['sid'] ?>" class="list-group-item"> 
						<h4><?= $sujet['Titre']?> :</h4>
						<p> <?= $sujet['Description'] ?></p> 
					</a>
				<?php elseif ($sujet['Statut']== '0' ):?> <!-- Si le sujet est fermé -->
					<li class="list-group-item"> 
						<h4><?= $sujet['Titre']?> :</h4>
						<p> <?= $sujet['Description'] ?></p> 		
					</li>
					<p> Ce sujet est fermé</p>
				<?php endif;?>	
				<?php if (isset($_SESSION['admin'])): ?> <!-- Si le sujet est ouvert et que l'utilisateur est un administrateur -->
					<?php if ($sujet['Statut']== '1'  && $_SESSION['admin'] == '1'):?>
						<form name="formFermetureSujet" action="#" method="POST">
							<input type="hidden" name="SujetAFermeID" value="<?= $sujet['sid']?>" required>
							<button type="submit" class="btn btn-warning"> Fermez le sujet </button>
						</form> 
					<?php elseif ($sujet['Statut']== '0'  && $_SESSION['admin'] == '1'):?> <!-- Si le sujet est fermé et que l'utilisateur est un administrateur -->
						<form name="formOuvertureSujet" action="#" method="POST">	
							<input type="hidden" name="SujetAReouvrirID" value="<?= $sujet['sid']?>" required>
							<button type="submit" class="btn btn-warning"> Réouvrir le sujet </button> 
						</form>		
					<?php endif;?>
				<?php endif;?>
			<?php endforeach ?>
		</ul>
	 </section>
<?php endforeach ?>