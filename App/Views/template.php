<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo|Concert+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="has-fixed-sidenav">
    <?php include('header.php') ?>
    <?php if (isset($flashbag)) : ?>
        <div class="valign-wrapper alert alert-<?= $flashbag['type'] ?>">
            <i class="alert-icon material-icons"><?= $flashbag['icon'] ?></i>
            <?= $flashbag['message'] ?>
        </div>
    <?php endif ?>

    <main>
        <?= $content ?>
    </main>

    <div id="modal-login" class="modal">
        <form id="login-form" action="?view=auth&action=login" method="post">
            <div class="modal-content">
                <h2 class="center-align">Se connecter</h2>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="username" required>
                        <label for="username">Pseudo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" name="password" required>
                        <label for="password">Mot de passe</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-flat waves-effect waves-light">Se connecter</button>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fermer</a>
            </div>
        </form>
    </div>

    <div id="modal-register" class="modal">
        <form id="registration-form" action="?view=auth&action=register" method="post">
            <div class="modal-content">
                <h2 class="center-align">S'inscrire</h2>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="username" required>
                        <label for="username">Pseudo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" name="password" required>
                        <label for="password">Mot de passe</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" name="email" required>
                        <label for="username">E-mail</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-flat waves-effect waves-light">S'inscrire</button>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fermer</a>
            </div>
        </form>
    </div>

    <?php include('footer.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="scripts/main.js"></script>
</body>

</html>