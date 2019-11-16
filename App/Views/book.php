<?php

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\UserModel; ?>

<div class="row">
    <article class="col s10 offset-s1">
        <div class="card">
            <div class="card-content">
                <div class="card-title">
                    <h2 class="center-align">Chapitre <?= $chapter->number ?> - <?= $chapter->title ?></h2>
                </div>
                <hr>
                <?= $chapter->content ?>
            </div>
            <div class="card-action">
                <div class="row">
                    <div class="col s6">
                        <?php if (!is_null($chapter->previousChapterUrl)) : ?>
                            <p class="center-align">
                                <a href="<?= $chapter->previousChapterUrl ?>" class="btn waves-effect waves-light blue-grey darken-1 white-text"><i class="material-icons left">navigate_before</i>Chapitre précedent</a>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="col s6">
                        <?php if (!is_null($chapter->nextChapterUrl)) : ?>
                            <p class="center-align">
                                <a href="<?= $chapter->nextChapterUrl ?>" class="btn waves-effect waves-light blue-grey darken-1 white-text"><i class="material-icons right">navigate_next</i>Chapitre suivant</a>
                            </p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<div class="row">
    <div class="col s10 offset-s1">
        <h5>
            <?php echo count($comments);
            if (count($comments) > 1) {
                echo ' commentaires';
            } else {
                echo ' commentaire';
            } ?>
        </h5>
        <div class="card">
            <?php if (Session::get('user')['role'] === UserModel::ROLE_ANONYMOUS) : ?>
                <div class="card-content">
                    <p>Vous devez être connecté pour écrire un commenraire.</p>
                </div>
                <div class="card-action">
                    <a href="#modal-login" class="btn-flat sidenav-elem modal-trigger blue-grey-text">Se connecter</a></button>
                    <a href="#modal-register" class="btn-flat sidenav-elem modal-trigger blue-grey-text">S'inscrire</a></button>
                </div>
            <?php else : ?>
                <form method="POST" action="/?view=book&action=publishComment&chapterId=<?= $chapter->id ?>">
                    <div class="card-content">
                        <div class="input-field">
                            <textarea name="comment-content" id="comment-content" class="materialize-textarea"></textarea>
                            <label for="comment-content">Votre commentaire...</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn waves-effect waves-light blue-grey">Publier</button>
                    </div>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
<?php foreach ($comments as $comment) : ?>
    <div class="row">
        <div class="col s10 offset-s1">
            <div class="card">
                <div class="card-content">
                    <em>Le <?= $comment->creation_date_fulltext ?>, par <?= $comment->author ?></em> - <a class="blue-grey-text">Signaler</a>
                    <blockquote><?= $comment->content ?></blockquote>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>