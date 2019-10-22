<?php ob_start(); ?>

<h2>Chapitres</h2>

<?php
while ($chapter = $chaptersList->fetch()) {
    ?>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><?= htmlspecialchars($chapter['title']); ?></span>
                </div>
                <div class="card-action">
                    <a href="#" class="indigo-text text-darken-4">Editer</a>
                    <a href="#" class="red-text">Supprimer</a>
                </div>
            </div>
        </div>
    </div>
    <?php    
}

$content = ob_get_clean() ?>

<?php require_once('template.php'); ?>