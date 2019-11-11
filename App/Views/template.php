<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="blue-grey darken-3">
    <?php
    include('menu.php');
    if (isset($_SESSION['flashbag'])) {
        ?>
        <div class="valign-wrapper alert alert-<?= $_SESSION['flashbag']['type'] ?>">
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
    echo $content;
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>