<?php ob_start() ?>

<div id="container-403">
	<div class="row">
		<div class="col s12 m6 error-message">
			<h2 class="center-align grey-text text-lighten-4">L'accès à cette page n'est pas autorisé</h2>
			<div class="center-align"><a href="/" class="waves-effect waves-light btn-large">Revenir à l'accueil</a></div>
		</div>
	</div>
</div>

<?php $content = ob_get_clean() ?>

<?php require_once('../App/Views/template.php') ?>