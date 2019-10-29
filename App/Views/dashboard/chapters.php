<?php ob_start() ?>

<div class="row">
    <h2>Chapitres</h2>
    <a class="btn waves-effect waves-light blue-grey darken-1"><i class="material-icons left">create</i>Ecrire un nouveau chapitre</a>
</div>
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s4"><a class="blue-grey-text text-darken-4" href="#drafts">Brouillons</a></li>
            <li class="tab col s4"><a class="blue-grey-text text-darken-4 active" href="#published">Publiés</a></li>
            <li class="tab col s4"><a class="blue-grey-text text-darken-4" href="#trash">Corbeille</a></li>
        </ul>
    </div>
    <div id="drafts" class="col s12">
        <?php if (empty($drafts)) : ?>
            <h5 class="center-align">Vous n'avez aucun brouillon en attente.</h5>
        <?php else : ?>
            <div class="row">
                <?php foreach ($drafts as $chapter) : ?>
                    <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Chapitre <?= $chapter['chapter_number'] ?> - <?= $chapter['title'] ?></span>
                                <p>Date de création : <?= $chapter['creation_date_fr'] ?></p>
                            </div>
                            <div class="card-action">
                                <a class="btn-small waves-effect waves-light blue darken-4"><i class="material-icons left">edit</i>Editer</a>
                                <a href="?view=chaptersPanel&action=moveToTrash&chapterId=<?= $chapter['id'] ?> "class="btn-small waves-effect waves-light red darken-4"><i class="material-icons left">delete</i>Mettre à la corbeille</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
    <div id="published" class="col s12">
        <?php if (empty($published)) : ?>
            <h5 class="center-align">Vos lecteurs n'ont rien à lire.</h5>
        <?php else : ?>
            <div class="row">
                <?php foreach ($published as $chapter) : ?>
                    <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Chapitre <?= $chapter['chapter_number'] ?> - <?= $chapter['title'] ?></span>
                                <p>Date de création : <?= $chapter['creation_date_fr'] ?></p>
                            </div>
                            <div class="card-action">
                                <a class="btn-small waves-effect waves-light blue darken-4"><i class="material-icons left">edit</i>Editer</a>
                                <a href="?view=chaptersPanel&action=moveToTrash&chapterId=<?= $chapter['id'] ?> "class="btn-small waves-effect waves-light red darken-4"><i class="material-icons left">delete</i>Mettre à la corbeille</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
    <div id="trash" class="col s12">
        <?php if (empty($trash)) : ?>
            <h5 class="center-align">La corbeille est vide.</h5>
        <?php else : ?>
            <div class="row">
                <?php foreach ($trash as $chapter) : ?>
                    <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Chapitre <?= $chapter['chapter_number'] ?> - <?= $chapter['title'] ?></span>
                                <p>Date de création : <?= $chapter['creation_date_fr'] ?></p>
                            </div>
                            <div class="card-action">
                                <a class="btn-small waves-effect waves-light blue darken-4"><i class="material-icons left">restore</i>Restaurer</a>
                                <a class="btn-small waves-effect waves-light red darken-4"><i class="material-icons left">delete_forever</i>Supprimer définitivement</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</div>

<?php $content = ob_get_clean() ?>

<?php require_once('template.php') ?>