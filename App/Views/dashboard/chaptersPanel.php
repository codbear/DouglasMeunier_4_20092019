<div class="container">
    <div class="row">
        <h2>Chapitres</h2>
        <a href="/?view=chapterEditor" class="btn waves-effect waves-light blue-grey darken-1"><i class="material-icons left">edit</i>Ecrire un nouveau chapitre</a>
    </div>
    <div class="row">
        <div class="col s12">
            <ul class="tabs tabs-fixed-width">
                <li class="tab"><a class="blue-grey-text text-darken-4" href="#drafts">Brouillons<?= count($drafts) > 0 ? '<span class="new badge green" data-badge-caption="">' . count($drafts) . '</span>' : '' ?></a></li>
                <li class="tab"><a class="blue-grey-text text-darken-4 active" href="#published">Publiés<?= count($published) > 0 ? '<span class="new badge blue" data-badge-caption="">' . count($published) . '</span>' : '' ?></a></li>
                <li class="tab"><a class="blue-grey-text text-darken-4" href="#trash">Corbeille<?= count($trash) > 0 ? '<span class="new badge red" data-badge-caption="">' . count($trash) . '</span>' : '' ?></a></li>
            </ul>
        </div>
        <div id="drafts" class="col s12">
            <?php if (empty($drafts)) : ?>
                <h5 class="center-align">Vous n'avez aucun brouillon en attente.</h5>
            <?php else : ?>
                <table class="centered white chapters-panel-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Titre</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drafts as $chapter) : ?>
                            <tr>
                                <th>
                                    <a href="?view=chapterEditor&chapterId=<?= $chapter->id ?>" title="Éditer" class="btn-small waves-effect waves-light blue"><i class="material-icons">edit</i></a>
                                    <a href="#modal-delete-chapter-<?= $chapter->id ?>" title="Supprimer" class="modal-trigger btn-small waves-effect waves-light red"><i class="material-icons">delete</i></a>
                                    <div id="modal-delete-chapter-<?= $chapter->id ?>" class="modal">
                                        <div class="modal-content">
                                        <h4>Demande de confirmation</h4>
                                            <p>Le chapitre <?= $chapter->number_save ?> "<?= $chapter->title ?>" va être déplacé vers la corbeille.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="?view=chaptersPanel&action=moveChapterToTrash&chapterId=<?= $chapter->id ?>" title="Supprimer" class="btn-small waves-effect waves-light red">Supprimer</a>
                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fermer</a>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <h4>Chapitre <?= $chapter->number_save ?> - <?= $chapter->title ?></h4>
                                    <p><?= $chapter->excerpt ?></p>
                                </th>
                                <th>
                                    <p><?= $chapter->creation_date_fr ?>
                                </th>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <div id="published" class="col s12">
            <?php if (empty($published)) : ?>
                <h5 class="center-align">Vos lecteurs n'ont rien à lire.</h5>
            <?php else : ?>
                <table class="centered white chapters-panel-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Titre</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($published as $chapter) : ?>
                            <tr>
                                <th>
                                    <a href="?view=chapterEditor&chapterId=<?= $chapter->id ?>" title="Éditer" class="btn-small waves-effect waves-light blue"><i class="material-icons">edit</i></a>
                                    <a href="#modal-delete-chapter-<?= $chapter->id ?>" title="Supprimer" class="modal-trigger btn-small waves-effect waves-light red"><i class="material-icons">delete</i></a>
                                    <div id="modal-delete-chapter-<?= $chapter->id ?>" class="modal">
                                        <div class="modal-content">
                                        <h4>Demande de confirmation</h4>
                                            <p>Le chapitre <?= $chapter->number_save ?> "<?= $chapter->title ?>" va être déplacé vers la corbeille.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="?view=chaptersPanel&action=moveChapterToTrash&chapterId=<?= $chapter->id ?>" title="Supprimer" class="btn-small waves-effect waves-light red">Supprimer</a>
                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fermer</a>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <h4>Chapitre <?= $chapter->number_save ?> - <?= $chapter->title ?></h4>
                                    <p><?= $chapter->excerpt ?></p>
                                </th>
                                <th>
                                    <p><?= $chapter->creation_date_fr ?>
                                </th>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <div id="trash" class="col s12">
            <?php if (empty($trash)) : ?>
                <h5 class="center-align">La corbeille est vide.</h5>
            <?php else : ?>
                <table class="centered white chapters-panel-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Titre</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trash as $chapter) : ?>
                            <tr>
                                <th>
                                    <a href="/?view=chaptersPanel&action=restoreChapterFromTrash&chapterId=<?= $chapter->id ?>" title="Restaurer" class="btn-small waves-effect waves-light green"><i class="material-icons">restore</i></a>
                                    <a href="#modal-delete-chapter-<?= $chapter->id ?>" title="Supprimer définitivement" class="modal-trigger btn-small waves-effect waves-light red"><i class="material-icons">delete_forever</i></a>
                                    <div id="modal-delete-chapter-<?= $chapter->id ?>" class="modal">
                                        <div class="modal-content">
                                            <h4>Demande de confirmation</h4>
                                            <p>Vous êtes sur le point de supprimer définitivement le chapitre <?= $chapter->number_save ?> "<?= $chapter->title ?>".</p>
                                            <i class="large material-icons red-text">error_outline</i>
                                            <p class="red-text">Attention, cette action est irréversible !</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/?view=chaptersPanel&action=deleteChapterPermanently&chapterId=<?= $chapter->id ?>" title="Supprimer définitivement" class="btn-small waves-effect waves-light red">Supprimer définitivement</a>
                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fermer</a>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <h4>Chapitre <?= $chapter->number_save ?> - <?= $chapter->title ?></h4>
                                    <p><?= $chapter->excerpt ?></p>
                                </th>
                                <th>
                                    <p><?= $chapter->creation_date_fr ?>
                                </th>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>