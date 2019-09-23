<?php ob_start();?>
		<div id="container-404">
			<h1 class="center-align grey-text text-darken-4">404</h1>
			<h2 class="center-align grey-text text-lighten-4">Ces contrées sont trop sauvages pour l'homme...</h2>
        </div>

<?php $content = ob_get_clean() ?>

<?php require_once('template.php'); ?>
