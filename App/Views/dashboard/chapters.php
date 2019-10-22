<?php ob_start(); ?>

<aside id="admin-menu" class="sidenav sidenav-fixed">
    <ul>
        <li><a href="?view=dashboard&section=chapters">Chapitres</a></li>
        <li><a href="?view=dashboard&section=comments">Commentaires</a></li>
        <li><a href="?view=dashboard&section=users">Utilisateurs</a></li>
        <li><a href="?view=dashboard&section=account">Mon compte</a></li>
    </ul>      
</aside>
<main>
    <div class="container">

    </div>      
</main>

<?php $content = ob_get_clean() ?>

<?php require_once('template.php'); ?>