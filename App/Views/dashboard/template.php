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
        <aside id="sidenav-left" class="sidenav sidenav-fixed">
        <ul>
            <li><a href="?view=dashboard&section=chapters">Chapitres</a></li>
            <li><a href="?view=dashboard&section=comments">Commentaires</a></li>
            <li><a href="?view=dashboard&section=users">Utilisateurs</a></li>
            <li><a href="?view=dashboard&section=account">Mon compte</a></li>
        </ul>      
    </aside>
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
    </body>
</html>
