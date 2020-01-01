<div class="container">
    <div class="row">
        <h2>Chapitres</h2>
        <a href="/?view=chaptersPanel&action=createNewChapter" class="btn waves-effect waves-light blue-grey darken-1"><i class="material-icons left">edit</i>Ecrire un nouveau chapitre</a>
    </div>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a class="blue-grey-text text-darken-4" href="#drafts">Brouillons<?= count($drafts) > 0 ? '<span class="new badge green" data-badge-caption="">' . count($drafts) . '</span>': '' ?></a></li>
                <li class="tab col s4"><a class="blue-grey-text text-darken-4 active" href="#published">Publiés<?= count($published) > 0 ? '<span class="new badge blue" data-badge-caption="">' . count($published) . '</span>': '' ?></a></li>
                <li class="tab col s4"><a class="blue-grey-text text-darken-4" href="#trash">Corbeille<?= count($trash) > 0 ? '<span class="new badge red" data-badge-caption="">' . count($trash) . '</span>': '' ?></a></li>
            </ul>
        </div>
        <div id="drafts" class="col s12">
            <?php if (empty($drafts)) : ?>
                <h5 class="center-align">Vous n'avez aucun brouillon en attente.</h5>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($drafts as $chapter) : ?>
                        <div class="col s12">
                            <div class="card">
                                <div class="row">
                                    <div class="col s8">
                                        <div class="card-content">
                                            <span class="card-title">Chapitre <?= $chapter->number_save ?> - <?= $chapter->title ?></span>
                                            <p>Date de création : <?= $chapter->creation_date_fr ?></p>
                                            <br>
                                            <p><?= $chapter->excerpt ?></p>
                                        </div>
                                    </div>
                                    <div class="col s4">
                                        <div class="card-action">
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="?view=chapterEditor&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light blue"><i class="material-icons left">edit</i>Editer</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="?view=chaptersPanel&action=moveChapterToTrash&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light red"><i class="material-icons left">delete</i>Mettre à la corbeille</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        <div class="col s12">
                            <div class="card">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="card-content">
                                            <span class="card-title">Chapitre <?= $chapter->number ?> - <?= $chapter->title ?></span>
                                            <p>Date de création : <?= $chapter->creation_date_fr ?></p>
                                            <br>
                                            <p><?= $chapter->excerpt ?></p>
                                        </div>
                                    </div>
                                    <div class="col s12">
                                        <div class="card-action">
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="?view=chapterEditor&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light blue"><i class="material-icons left">edit</i>Editer</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="?view=chaptersPanel&action=moveChapterToTrash&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light red"><i class="material-icons left">delete</i>Mettre à la corbeille</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        <div class="col s12">
                            <div class="card">
                                <div class="row">
                                    <div class="col s8">
                                        <div class="card-content">
                                            <span class="card-title">Chapitre <?= $chapter->number_save ?> - <?= $chapter->title ?></span>
                                            <p>Date de création : <?= $chapter->creation_date_fr ?></p>
                                            <br>
                                            <p><?= $chapter->excerpt ?></p>
                                        </div>
                                    </div>
                                    <div class="col s4">
                                        <div class="card-action">
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="/?view=chaptersPanel&action=restoreChapterFromTrash&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light green"><i class="material-icons left">restore</i>Restaurer</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12">
                                                    <a href="/?view=chaptersPanel&action=deleteChapterPermanently&chapterId=<?= $chapter->id ?>" class="btn-small waves-effect waves-light black"><i class="material-icons left">delete_forever</i>Supprimer définitivement</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>