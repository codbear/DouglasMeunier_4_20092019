<?php

use Codbear\Alaska\Models\ChapterModel;

ob_start(); ?>
<div class="row blue-grey darken-3">
    <aside id="table-of-content" class="col m2 blue-grey darken-3 white-text">
        <h2>Sommaire</h2>
        <?php foreach ($tableOfContent as $chapterLink) : ?>
            <?php if ($chapterLink->status == ChapterModel::STATUS_PUBLISHED) : ?>
                <p><a href="<?= $chapterLink->Url ?>" class="white-text">Chapitre <?= $chapterLink->number ?> - <?= $chapterLink->title ?></a></p>
            <?php endif ?>
        <?php endforeach ?>
    </aside>
    <article class="col m8 offset-m3 blue-grey darken-3">
        <?php if (is_null($chapter)) : ?>
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">
                                <h1 class="center-align">Un billet pour l'Alaska</h1>
                            </div>
                            <h4 class="center-align">Par Jean Forteroche</h4>
                            <img src="public/img/book-cover.jpg" alt="Image de couverture du livre montrant une aurore boréale" id='book-cover'>
                        </div>
                        <div class="card-action">
                            <p class="center-align">
                                <?php if ($enableCoverButton) : ?>
                                    <a href="/?view=book&chapterId=1" class="btn waves-effect waves-light blue-grey darken-3 white-text">Commencer la lecture</a>
                                <?php else : ?>
                                    <a href="/?view=book&chapterId=1" class="btn waves-effect waves-light blue-grey darken-3 white-text disabled">Commencer la lecture</a>
                                <?php endif ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col s12">
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
                                            <a href="<?= $chapter->previousChapterUrl ?>" class="btn waves-effect waves-light blue-grey darken-3 white-text"><i class="material-icons left">navigate_before</i>Chapitre précedent</a>
                                        </p>
                                    <?php endif ?>
                                </div>
                                <div class="col s6">
                                    <?php if (!is_null($chapter->nextChapterUrl)) : ?>
                                        <p class="center-align">
                                            <a href="<?= $chapter->nextChapterUrl ?>" class="btn waves-effect waves-light blue-grey darken-3 white-text"><i class="material-icons right">navigate_next</i>Chapitre suivant</a>
                                        </p>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
    </article>

</div>
<?php $content = ob_get_clean();
require('template.php'); ?>