<div class="row">
    <article class="col s10 offset-s1 ">
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