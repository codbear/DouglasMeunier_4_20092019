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
                        <li class="tab col s6"><a class="blue-grey-text text-darken-4" href="#signaled">Signalés<span class="new badge <?= ($signaled) ? 'red' : 'green' ?>" data-badge-caption=""><?= count($signaled) ?></span></a></li>
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
                                            <th>Chapitre</th>
                                            <th>Auteur</th>
                                            <th>Commentaire</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($comments as $comment) : ?>
                                            <tr>
                                                <th><?= $comment->chapter_number ?></th>
                                                <th><?= $comment->author ?></th>
                                                <th>
                                                    <?= $comment->content ?>
                                                    <?php if ($comment->reporting > 0) : ?>
                                                        <span class="right new badge red" data-badge-caption="Signalé"></span>
                                                    <?php endif ?>
                                                </th>
                                                <th><a href="<?= $comment->deleteUrl ?>"><i class="material-icons black-text">delete_forever</i></a></th>
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
                                            <th>Chapitre</th>
                                            <th>Auteur</th>
                                            <th>Commentaire</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($signaled as $comment) : ?>
                                            <tr>
                                                <th><?= $comment->chapter_number ?></th>
                                                <th><?= $comment->author ?></th>
                                                <th>
                                                    <?= $comment->content ?>
                                                    <span class="right new badge red" data-badge-caption="<?= ($comment->reporting > 1) ? 'signalements' : 'signalement' ?>"><?= $comment->reporting ?></span>
                                                </th>
                                                <th><a href="<?= $comment->deleteUrl ?>"><i class="material-icons black-text">delete_forever</i></a></th>
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