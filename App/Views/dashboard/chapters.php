<?php ob_start(); ?>

<h2>Chapitres</h2>
<a class="btn waves-effect waves-light indigo"><i class="material-icons left">create</i>Ecrire un nouveau chapitre</a>

<?php
while ($chapter = $chaptersList->fetch()) {
    ?>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Chapitre <?= $chapter['chapter_number']; ?> - <?= $chapter['title']; ?></span>
                    <p>Date de création : <?= $chapter['creation_date_fr']; ?></p>
                </div>
                <div class="card-action">
                    <a class="btn-small waves-effect waves-light blue"><i class="material-icons left">edit</i>Editer</a>
                    <a class="btn-small waves-effect waves-light red"><i class="material-icons left">delete</i>Supprimer</a>
                </div>
            </div>
        </div>
    </div>
    <?php    
}

$content = ob_get_clean() ?>

<?php require_once('template.php'); ?>