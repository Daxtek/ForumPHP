<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="css/VerificationFormulaire.css" rel="stylesheet">
		<title><?= $titlePage ?></title>
	</head>
	<body >

		<?php include 'nav.php'; ?>

		<section class="container"> <!-- Section centrale -->
			<?php if(!empty($errorMessage)):?>
				<p class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></p>
			<?php endif;?>