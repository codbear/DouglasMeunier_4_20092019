<?php

use Codbear\Alaska\Models\BookModel;

ob_start() ?>

<div class="row">
    <div class="col s12">
        <form action="?view=chapterEditor&action=saveChapter&chapterId=<?= $chapter->id ?>" method="post" class="card blue-grey lighten-5">
            <div class="card-title">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <h1>Editeur de chapitre</h1>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <div class="row">
                    <div class="col m8 l7 xl6">
                        <div class="row">
                            <div class="col m6">
                                <button type="submit" class="btn waves-effect waves-light green darken-4"><i class="material-icons left">save</i>Enregistrer</button>
                            </div>
                            <div class="col m6">
                                <a href="?view=chaptersPanel&action=moveChapterToTrash&chapterId=<?= $chapter->id ?>" class="btn waves-effect waves-light red darken-4"><i class="material-icons left">delete</i>Supprimer</a>
                            </div>
                        </div>
                    </div>
                    <?php if ($chapter->chapter_status != BookModel::CHAPTER_STATUS_PUBLISHED) : ?>
                        <div class="col s12 l3 offset-l2 offset-xl3">
                            <button type="submit" formaction="/?view=chapterEditor&action=publishChapter&chapterId=<?= $chapter->id ?>" class="btn waves-effect waves-light blue darken-4"><i class="material-icons left">publish</i>Publier</button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="card-tabs">
                <ul class="tabs tabs-fixed-width">
                    <li class="tab"><a class="blue-grey-text text-darken-4 active" href="#chapter-metadatas">Métadonnées</a></li>
                    <li class="tab"><a class="blue-grey-text text-darken-4" href="#chapter-content">Contenu</a></li>
                </ul>
            </div>
            <div class="card-content">
                <div id="chapter-metadatas">
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input type="text" name="chapter-title" id="chapter-title" class="validate" value="<?= $chapter->title ?>" required>
                            <label for="chapter-title">Titre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m2 offset-m2">
                            <input type="number" name="chapter-number" id="chapter-number" class="validate" value="<?= $chapter->chapter_number ?>" required>
                            <label for="chapter-number">Chapitre n°</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <textarea class="tiny-editor" name="chapter-excerpt" id="chapterExcerpt"><?= $chapter->excerpt ?></textarea>
                            <label for="chapter-excerpt">Extrait</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 offset-m2">
                            <p>Date de création : <?= $chapter->creation_date_fr ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chapter-content">
                <div class="row">
                    <div class="col s10 offset-s1">
                        <textarea class="tiny-editor" name="chapter-content" id="chapterContent"><?= $chapter->content ?></textarea>
                        <br>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="public/scripts/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="public/scripts/chapterEditor.js"></script>

<?php $content = ob_get_clean() ?>

<?php require_once('template.php') ?>