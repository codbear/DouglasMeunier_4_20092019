<?php ob_start(); ?>
<div class="row">
    <aside id="table-of-content" class="col s2 blue-grey darken-3 white-text">
        <h2>Sommaire</h2>
        <?php foreach ($tableOfContent as $chapterLink) : ?>
            <p><a href="<?= $chapterLink->Url ?>" class="white-text">Chapitre <?= $chapterLink->number ?> - <?= $chapterLink->title ?></a></p>
        <?php endforeach ?>
    </aside>
    <article class="col s8 offset-s3">
        <div class="row">
            <div class="col s12">
                <h2>Chapitre <?= $chapter->number ?> - <?= $chapter->title ?></h2>
                <?= $chapter->content ?>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <?php if (!is_null($chapter->previousChapterUrl)) : ?>
                    <a href="<?= $chapter->previousChapterUrl ?>">Chapitre précedent</a>
                <?php endif ?>
            </div>
            <div class="col s6">
                <?php if (!is_null($chapter->nextChapterUrl)) : ?>
                    <a href="<?= $chapter->nextChapterUrl ?>">Chapitre suivant</a>
                <?php endif ?>
            </div>
        </div>
    </article>
</div>
<?php $content = ob_get_clean();
require('template.php'); ?>