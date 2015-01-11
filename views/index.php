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
			<a href="Sujet.php?Titresujet=<?= $sujet['Titre'] ?>" class="list-group-item">
				<h4><?= $sujet['Titre']?> :</h4>
				<p> <?= $sujet['Description'] ?></p>
			</a>
		<?php endforeach ?>
		</ul>
	 </section>
<?php endforeach ?>