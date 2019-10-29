<?php ob_start() ?>

<div id="container-401">
	<div class="row">
		<div class="col s12 m6 error-message">
			<h2 class="center-align grey-text text-lighten-4">Vous devez être connecté pour accéder à cette page</h2>
			<div class="center-align"><a href="/?view=login" class="waves-effect waves-light btn-large">Se connecter / S'inscrire</a></div>
		</div>
	</div>
</div>

<?php $content = ob_get_clean() ?>

<?php require_once('../App/Views/template.php') ?>