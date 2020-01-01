<div class="container">
    <div class="row">
        <h2>Commentaires</h2>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab col s6"><a class="blue-grey-text text-darken-4 active" href="#all">Tous</a></li>
                        <li class="tab col s6"><a class="blue-grey-text text-darken-4" href="#signaled">Signalés<?= count($signaled) > 0 ? '<span class="new badge red" data-badge-caption="">' . count($signaled) . '</span>' : '' ?></a></li>
                    </ul>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div id="all" class="col s12">
                            <?php if (empty($comments)) : ?>
                                <h5 class="center-align">Aucun commentaire</h5>
                            <?php else : ?>
                                <table class="highlight">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Chapitre</th>
                                            <th>Auteur</th>
                                            <th>Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($comments as $comment) : ?>
                                            <tr>
                                                <th>
                                                    <a href="#modal-delete-comment-<?= $comment->id ?>" title="Supprimer définitivement" class="modal-trigger btn-small red"><i class="material-icons">delete_forever</i></a>
                                                    <div id="modal-delete-comment-<?= $comment->id ?>" class="modal">
                                                        <div class="modal-content center">
                                                            <h4>Demande de confirmation</h4>
                                                            <p>Vous êtes sur le point de supprimer le commentaire de <?= $comment->author ?>.</p>
                                                            <i class="large material-icons red-text">error_outline</i>
                                                            <p class="red-text">Attention, cette action est irréversible !</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="<?= $comment->deleteUrl ?>" title="Supprimer définitivement" class="btn-small waves-effect waves-light red">Supprimer définitivement</a>
                                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat black-text">Fermer</a>
                                                        </div>
                                                    </div>
                                                    <?php if ($comment->reporting > 0) : ?>
                                                        <a href="<?= $comment->validateUrl ?>" title="Approuver" class="btn-small green"><i class="material-icons">done_all</i></a>
                                                    <?php endif ?>
                                                </th>
                                                <th><?= $comment->chapter_number ?></th>
                                                <th><?= $comment->author ?></th>
                                                <th>
                                                    <?php if ($comment->reporting > 0) : ?>
                                                        <span class="right new badge orange" data-badge-caption="Signalé"></span>
                                                    <?php endif ?>
                                                    <?= $comment->content ?>
                                                </th>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php endif ?>
                        </div>
                        <div id="signaled" class="col s12">
                            <?php if (empty($signaled)) : ?>
                                <h5 class="center-align">Aucun commentaire signalé</h5>
                            <?php else : ?>
                                <table class="highlight">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Chapitre</th>
                                            <th>Auteur</th>
                                            <th>Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($signaled as $comment) : ?>
                                            <tr>
                                                <th>
                                                    <a href="#modal-delete-signaled-comment-<?= $comment->id ?>" title="Supprimer définitivement" class="modal-trigger btn-small red"><i class="material-icons">delete_forever</i></a>
                                                    <div id="modal-delete-signaled-comment-<?= $comment->id ?>" class="modal">
                                                        <div class="modal-content center">
                                                            <h4>Demande de confirmation</h4>
                                                            <p>Vous êtes sur le point de supprimer le commentaire de <?= $comment->author ?>.</p>
                                                            <i class="large material-icons red-text">error_outline</i>
                                                            <p class="red-text">Attention, cette action est irréversible !</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="<?= $comment->deleteUrl ?>" title="Supprimer définitivement" class="btn-small waves-effect waves-light red">Supprimer définitivement</a>
                                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat black-text">Fermer</a>
                                                        </div>
                                                    </div>
                                                    <a href="<?= $comment->validateUrl ?>" title="Approuver" class="btn-small green"><i class="material-icons">done_all</i></a>
                                                </th>
                                                <th><?= $comment->chapter_number ?></th>
                                                <th><?= $comment->author ?></th>
                                                <th>
                                                    <span class="right new badge orange" data-badge-caption="<?= ($comment->reporting > 1) ? 'signalements' : 'signalement' ?>"><?= $comment->reporting ?></span>
                                                    <?= $comment->content ?>
                                                </th>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>