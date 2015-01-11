<header>
	<h1> Bienvenue sur le forum !! </h1>
</header>

<?php foreach ($forum as $categorieKey => $categorie): ?>
	<!-- Affichage des catégories -->
	<section  class="panel panel-primary"> 
		<div class="panel-heading">
			<h1 class="panel-title" ><?= $categorie['Titre']?></h1>
		</div>
		<div class="panel-body">
				<p ><?= $categorie['Description']?></p>
			<ul class="list-group">
				<!-- Affichage des sujets, premier jets -->
				<?php foreach ($categorie['sujets'] as $sujetKey => $sujet): ?>
					<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1'): ?> <!-- Si l'utilisateur est connecté et que c'est un administrateur -->
						<?php if ($sujet['Statut']== '1' ):?> <!-- Si le sujet est ouvert -->
							<a href="Sujet.php?sid=<?= $sujet['sid'] ?>" class="list-group-item col-lg-10"> 
								<h4><?= $sujet['Titre']?> :</h4>
								<p> <?= $sujet['Description'] ?></p> 
							</a>
							<form name="formFermetureSujet" action="#" method="POST" >
								<div class="form-group col-lg-2">
									<input type="hidden" name="SujetAFermeID" value="<?= $sujet['sid']?>" required>
									<button type="submit" class="btn btn-warning"> Fermez le sujet </button>
								</div>
							</form> 
						<?php elseif ($sujet['Statut']== '0' ):?> <!-- Si le sujet est fermé  -->
							<li class="list-group-item col-lg-10 disabled"> 
								<h4><?= $sujet['Titre']?> :</h4>
								<p> <?= $sujet['Description'] ?></p> 		
							</li>
							<form name="formOuvertureSujet" action="#" method="POST">	
								<div class="form-group col-lg-2">
									<input type="hidden" name="SujetAReouvrirID" value="<?= $sujet['sid']?>" required>
									<button type="submit" class="btn btn-warning"> Réouvrir le sujet </button> 
								</div>
							</form>		
						<?php endif;?>
					<?php else:?> 
						<?php if ($sujet['Statut']== '1' ):?> <!-- Si le sujet est ouvert -->
							<a href="Sujet.php?sid=<?= $sujet['sid'] ?>" class="list-group-item "> 
								<h4><?= $sujet['Titre']?> :</h4>
								<p> <?= $sujet['Description'] ?></p> 
							</a>
						<?php elseif ($sujet['Statut']== '0' ):?> <!-- Si le sujet est fermé -->
							<li class="list-group-item disabled" > 
								<h4><?= $sujet['Titre']?> :</h4>
								<p> <?= $sujet['Description'] ?></p> 		
							</li>
						<?php endif;?>
					<?php endif;?>
				<?php endforeach ?>
			</ul>
		</div>
	 </section>
<?php endforeach ?>