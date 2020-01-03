<?php

use Codbear\Alaska\Models\ChaptersModel;

?>

<div class="row">
    <div class="col s10 offset-s1">
        <div class="row">
            <h2>Editeur de chapitre</h2>
        </div>
        <form action="<?= $chapter->saveUrl ?> " method="post">
            <div class="card">
                <div class="card-action">
                    <div class="row">
                        <div class="col s3 m2 xl1">
                            <?php if (!isset($chapter->status) || $chapter->status != ChaptersModel::STATUS_PUBLISHED) : ?>
                                <button type="submit" formaction="<?= $chapter->publishUrl ?>" title="Publier" class="btn blue">
                                    <i class="material-icons">publish</i>
                                </button>
                            <?php endif ?>
                        </div>
                        <div class="col s3 m2 xl1">
                            <button type="submit" title="Enregistrer" class="btn green"><i class="material-icons">save</i></button>
                        </div>
                        <div class="col s3 m2 xl1">
                            <a href="#modal-delete-chapter" title="Supprimer" class="modal-trigger btn red"><i class="material-icons">delete</i></a>
                            <div id="modal-delete-chapter" class="modal">
                                <div class="modal-content center">
                                    <h4>Demande de confirmation</h4>
                                    <p>Vous êtes sur le point de supprimer ce chapitre.</p>
                                    <i class="large material-icons red-text">error_outline</i>
                                    <p class="red-text">Attention, si le chapitre n'a jamais été enregistré, il sera supprimé définitivement !</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="<?= $chapter->MoveToTrashUrl ?>" title="Supprimer" class="btn red">Supprimer</a>
                                    <a href="#!" class="modal-close waves-effect waves-green btn-flat black-text">Fermer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-tabs">
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab"><a class="blue-grey-text text-darken-4 active" href="#chapter-metadatas">Métadonnées</a></li>
                            <li class="tab"><a class="blue-grey-text text-darken-4" href="#chapter-content">Contenu</a></li>
                        </ul>
                    </div>
                    <div id="chapter-metadatas">
                        <div class="row">
                            <div class="input-field col s12 xl8 offset-xl2">
                                <input type="text" name="chapter-title" id="chapter-title" class="validate" <?= isset($chapter->title) ? 'value="' . $chapter->title . '"' : '' ?> required>
                                <label for="chapter-title">Titre</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 xl2 offset-xl2">
                                <input type="number" name="chapter-number" id="chapter-number" class="validate" <?= isset($chapter->number) ? 'value="' . $chapter->number . '"' : '' ?> required>
                                <label for="chapter-number">Chapitre n°</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 xl8 offset-xl2">
                                <textarea class="tiny-editor" name="chapter-excerpt" id="chapterExcerpt"><?= isset($chapter->excerpt) ? "$chapter->excerpt" : '' ?></textarea>
                                <label for="chapter-excerpt">Extrait</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chapter-content">
                    <div class="row">
                        <div class="col s10 offset-s1">
                            <textarea class="tiny-editor" name="chapter-content" id="chapterContent"><?= isset($chapter->content) ? "$chapter->content" : '' ?></textarea>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/92voo0o596sf8t22270uv9ktk2a01r4yaau6n0eseb8a1omk/tinymce/5/tinymce.min.js"></script> 
<script src="scripts/chapterEditor.js"></script>