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
                                                    <?php if ($comment->reporting > 0) : ?>
                                                        <a href="<?= protect($comment->validateUrl) ?>"><i class="material-icons green-text">done_all</i></a>
                                                    <?php endif ?>
                                                    <a href="<?= protect($comment->deleteUrl) ?>"><i class="material-icons red-text">delete_forever</i></a>
                                                </th>
                                                <th><?= protect($comment->chapter_number) ?></th>
                                                <th><?= protect($comment->author) ?></th>
                                                <th>
                                                    <?= protect($comment->content) ?>
                                                    <?php if ($comment->reporting > 0) : ?>
                                                        <span class="right new badge orange" data-badge-caption="Signalé"></span>
                                                    <?php endif ?>
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
                                                    <a href="<?= protect($comment->validateUrl) ?>"><i class="material-icons green-text">done_all</i></a>
                                                    <a href="<?= protect($comment->deleteUrl) ?>"><i class="material-icons red-text">delete_forever</i></a>
                                                </th>
                                                <th><?= protect($comment->chapter_number) ?></th>
                                                <th><?= protect($comment->author) ?></th>
                                                <th>
                                                    <?= protect($comment->content) ?>
                                                    <span class="right new badge orange" data-badge-caption="<?= ($comment->reporting > 1) ? 'signalements' : 'signalement' ?>"><?= protect($comment->reporting) ?></span>
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