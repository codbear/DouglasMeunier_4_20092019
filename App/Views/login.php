<?php ob_start();?>
    <div class="row">
        <form id="login-form" class="col s6" action="?view=login&action=login" method="post">
            <div class="row">
                <h2 class="col s6 offset-s4">Se connecter</h2>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s4">
                    <input type="text" name="username" required>
                    <label for="username">Pseudo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s4">
                    <input type="password" name="password" required>
                    <label for="password">Mot de passe</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s4">
                    <input type="submit" value="Se connecter">
                </div>
            </div>
        </form>
        <form id="registration-form" class="col s6" action="?view=login&action=register" method="post">
            <div class="row">
                <h2 class="col s6 offset-s2">S'inscrire</h2>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s2">
                    <input type="text" name="username" required>
                    <label for="username">Pseudo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s2">
                    <input type="password" name="password" required>
                    <label for="password">Mot de passe</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s2">
                    <input type="email" name="email" required>
                    <label for="username">E-mail</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s2">
                    <input type="submit" value="S'inscrire">
                </div>
            </div>
        </form>
    </div>
<?php $content = ob_get_clean();

require_once('template.php'); ?>
