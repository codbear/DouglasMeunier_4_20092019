<?php

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\Tables\ChaptersTable;
use Codbear\Alaska\Models\Tables\UsersTable; ?>

<header>
    <ul id="slide-out" class="sidenav sidenav-fixed blue-grey lighten-3">
        <li class="sidenav-header">
            <h1 class="center-align white-text">Billet simple pour l'Alaska</h1>
        </li>
        <li>
            <ul>
                <li class="waves-effect"><a href="/" class="sidenav-elem">Accueil</a></li>
                <li class="waves-effect"><a href="#" data-target="table-of-chapters" class="sidenav-trigger show-on-large sidenav-elem">Lire</a></li>
                <?php if (Session::get('user')['role'] !== UsersTable::ROLE_ANONYMOUS) : ?>
                    <?php if (Session::get('user')['role'] == UsersTable::ROLE_ADMIN) : ?>
                        <li>
                            <ul class="collapsible collapsible-accordion">
                                <li>
                                    <a class="collapsible-header">Dashboard<i class="material-icons right">arrow_drop_down</i></a>
                                    <div class="collapsible-body">
                                        <ul class="blue-grey lighten-4">
                                            <li class="waves-effect"><a href="?view=chaptersPanel"><i class="material-icons left">book</i>Chapitres</a></li>
                                            <li class="waves-effect"><a href="?view=commentsPanel"><i class="material-icons left">comment</i>Commentaires</a></li>
                                            <li class="waves-effect"><a href="?view=usersPanel"><i class="material-icons left">people</i>Utilisateurs</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php endif ?>
                    <li>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Mon compte<i class="material-icons right">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul class="blue-grey lighten-4">
                                        <li class="waves-effect"><a href="?view=accountSettings"><i class="material-icons left">settings</i>Paramètres</a></li>
                                        <li class="waves-effect"><a href="?view=login&action=logout"><i class="material-icons left">logout</i>Se déconnecter</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class=" waves-effect waves-light"><a href="#modal-login" class="sidenav-elem modal-trigger">Se connecter</a></li>
                    <li class=" waves-effect waves-light"><a href="#modal-register" class="sidenav-elem modal-trigger">S'inscrire</a></li>
                <?php endif ?>
            </ul>
        </li>
    </ul>
    <a id="mobile-menu-trigger" href="#" data-target="slide-out" class="btn waves-effect waves-light sidenav-trigger hide-on-large-only blue-grey"><i class="material-icons">menu</i></a>

    <ul id="table-of-chapters" class="sidenav blue-grey lighten-4">
        <li class="sidenav-header">
            <button class="btn-floating btn-small waves-effect waves-light sidenav-close right blue-grey"><i class="material-icons small">close</i></button>
            <h1 class="center-align">- Sommaire -</h1>
        </li>
        <li>
            <ul>
                <?php foreach ($tableOfContent as $chapterLink) : ?>
                    <?php if ($chapterLink->status == ChaptersTable::STATUS_PUBLISHED) : ?>
                        <li>
                            <a href="<?= $chapterLink->url ?>" class="black-text">Chapitre <?= $chapterLink->number ?> - <?= $chapterLink->title ?></a>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </li>
    </ul>
</header>