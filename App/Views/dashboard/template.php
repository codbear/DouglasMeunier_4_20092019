<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body class="has-fixed-sidenav">
    <header>
        <div class="navbar-fixed">
            <nav class="navbar blue-grey darken-1">
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Un billet pour l'Alaska</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="/"><i class="material-icons left">home</i>Retourner sur le site</a></li>
                        <li><a href="?view=login&action=logout">Se déconnecter</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <ul id="sidenav-left" class="sidenav sidenav-fixed blue-grey lighten-3">
            <li class="waves-effect">
                <a href="?view=chaptersPanel" class="logo-container"><i class="material-icons left small">dashboard</i>Dashboard</a>
            </li>
            <li>
                <ul>
                    <li class="waves-effect"><a href="?view=chaptersPanel"><i class="material-icons left">book</i>Chapitres</a></li>
                    <li class="waves-effect"><a href="?view=commentsPanel"><i class="material-icons left">comment</i>Commentaires</a></li>
                    <li class="waves-effect"><a href="?view=usersPanel"><i class="material-icons left">people</i>Utilisateurs</a></li>
                    <li class="waves-effect"><a href="?view=accountPanel"><i class="material-icons left">settings</i>Mon compte</a></li>
                </ul> 
            </li>
        </ul>
    </header>
        
    <main>
        <?php 
        if (isset($_SESSION['flashbag'])) {
            ?>
            <div class="valign-wrapper alert alert-<?= $_SESSION['flashbag']['type']?>">
            <i class="alert-icon material-icons">
                <?php
                switch ($_SESSION['flashbag']['type']) {
                    case 'success':
                        echo 'check';
                        break;

                    case 'warning':
                        echo 'warning';
                        break;

                    case 'error':
                        echo 'error_outline';
                        break;
                    
                    default:
                        echo 'info_outline';
                        break;
                }
                ?>
            </i>
            <?= $_SESSION['flashbag']['message']; ?>
            </div>
            <?php
            unset($_SESSION['flashbag']);
        }
        ?>
        <div class="container">
            <?php
            echo $content; 
            ?>
        </div>      
    </main>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="/scripts/main.js"></script>
    </body>
</html>
