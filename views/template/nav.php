		<nav class="navbar navbar-inverse navbar-fixed-top"><!-- Barre de navigation principal -->
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="./">Forum PHP</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<?php if (!isset($_SESSION['utilisateur_id'])): ?> <!--  Si la variable de session n'a pas été créer ( si la personne n'est pas connectée au site ) -->
						<form name="formConnexion" action="" method="POST" class="navbar-form navbar-right">
							<div class="form-group">
								<input type="text" name="pseudo" size="20" maxlength="20"  placeholder="Pseudonyme" class="form-control" required>
							</div>
							<div class="form-group">
								<input type="password" placeholder="Mot de passe" class="form-control" name="mdp" required>
							</div>
							<button type="submit" class="btn btn-success">Se connecter</button>
							<a class="btn btn-primary" href="inscription.php">Inscription</a>
						</form>
					<?php else: ?> <!-- Si la personne est connecté -->
						<ul class="nav navbar-nav">
							<li><a href="profil.php"> Profil </a>
						<?php if(($_SESSION['admin']) == '1'): ?> <!--  Si la personne qui est connecté est pas  administrateur alors elle peut accéder aux rubriques qui suivent -->
							
								<li><a  href="inscription.php"> Inscrire un nouvel utilisateur </a></li>
								<li><a  href="creation_categorie.php"> Créer Catégorie </a></li>
							
						<?php endif; ?>
						</ul>
						<a class="btn btn-primary navbar-btn navbar-right" href="deconnexion.php"> Deconnexion </a>
					<?php endif; ?>
				</div>
			</div>
		</nav>