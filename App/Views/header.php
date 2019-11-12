<?php

use Codbear\Alaska\Models\UserModel; ?>

<header>
    <div class="navbar-fixed">
        <nav class="blue-grey darken-1">
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo">Un billet pour l'Alaska</a>
                <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/?view=book">Lire</a></li>
                    <?php switch ($_SESSION['role']):
                        case UserModel::ROLE_SUBSCRIBER:
                            ?>
                            <li><a href="?view=login&action=logout">Se déconnecter</a></li>
                        <?php
                            break;

                        case UserModel::ROLE_ADMIN:
                            ?>
                            <li><a href="?view=chaptersPanel">Dashboard</a></li>
                            <li><a href="?view=login&action=logout">Se déconnecter</a></li>
                        <?php
                            break;

                        default:
                            ?>
                            <li><a href="?view=login">Se connecter / S'inscrire</a></li>
                        <?php
                            break;
                    endswitch; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>