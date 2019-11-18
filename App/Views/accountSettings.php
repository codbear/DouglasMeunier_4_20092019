<div class="container">
    <div class="row">
        <h2>Paramètres du compte</h2>
    </div>
    <div class="row">
        <div class="col s12">
            <form action="?view=accountSettings&action=updateAccount&userId=<?= $user->id ?>" method="post" class="card">
                <div class="card-content">
                    <div class="card-title">
                        <h3>Profil</h3>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="text" name="chapter-title" id="chapter-title" class="validate" value="<?= $user->username ?>" disabled>
                            <label for="chapter-title">Nom d'utilisateur</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="email" name="email" id="email" class="validate" value="<?= $user->email ?>" required>
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn waves-effect waves-light green">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form action="?view=accountSettings&action=updatePassword&userId=<?= $user->id ?>" method="post" class="card">
                <div class="card-content">
                    <div class="card-title">
                        <h3>Sécurité</h3>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="password" name="actual-password" id="actual-password" class="validate" required>
                            <label for="actual-password">Mot de passe actuel</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="password" name="new-password" id="new-password" class="validate" required>
                            <label for="new-password">Nouveau mot de passe</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="password" name="new-password-confirmation" id="new-password-confirmation" class="validate" required>
                            <label for="new-password-confirmation">Confirmer le nouveau mot de passe</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn waves-effect waves-light green">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form action="?view=accountSettings&action=deleteAccount&userId=<?= $user->id ?>" method="post" class="card">
                <div class="card-content">
                    <div class="card-title">
                        <h3>Supprimer le compte</h3>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col s1 offset-s1">
                            <i class="material-icons medium red-text">error_outline</i>
                        </div>
                        <div class="col s11 xl8">
                            <p>La suppression de votre compte entraine la suppression de toutes vos données personelles, ainsi que tous les commentaires
                                que vous avez postés.<br><strong class="bold red-text">Cette action est irréversible !</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 xl8 offset-xl2">
                            <input type="password" name="password" id="password" class="validate" required>
                            <label for="password">Mot de passe</label>
                            <span class="helper-text black-text" data-error="wrong" data-success="right">Veuillez saisir votre mot de passe pour supprimer définitivement votre compte.</span>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn waves-effect waves-light red">Supprimer mon compte</button>
                </div>
            </form>
        </div>
    </div>
</div>