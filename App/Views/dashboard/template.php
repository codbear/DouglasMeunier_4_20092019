<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="public/css/style.css">

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="public/scripts/backOffice.js"></script>
</body>

</html>