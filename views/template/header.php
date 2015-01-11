<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/VerificationFormulaire.css" rel="stylesheet">
		<title><?= $titlePage ?></title>
	</head>
	<body >

		<?php include 'nav.php'; ?>

		<?php if(!empty($errorMessage)):?>
			<p class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></p>
		<?php endif;?>


		<section class="container"> <!-- Section centrale -->