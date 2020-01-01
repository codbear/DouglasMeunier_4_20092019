<div class="container">
    <div class="row">
        <h2>Utilisateurs</h2>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Pseudo</th>
                                <th>E-mail</th>
                                <th>Rôle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <th>
                                        <?php if ($user->role !== "Administrateur") : ?>
                                            <a href="#modal-delete-user-<?= $user->id ?>" title="Supprimer définitivement" class="modal-trigger btn-small red"><i class="material-icons">delete_forever</i></a>
                                            <div id="modal-delete-user-<?= $user->id ?>" class="modal">
                                                <div class="modal-content center">
                                                    <h4>Demande de confirmation</h4>
                                                    <p>Vous êtes sur le point de supprimer le compte utilisateur de <?= $user->username ?>.</p>
                                                    <i class="large material-icons red-text">error_outline</i>
                                                    <p class="red-text">Attention, cette action est irréversible !</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= $user->deleteUrl ?>" title="Supprimer définitivement" class="btn-small waves-effect waves-light red">Supprimer définitivement</a>
                                                    <a href="#!" class="modal-close waves-effect waves-green btn-flat black-text">Fermer</a>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </th>
                                    <th><?= $user->id ?></th>
                                    <th><?= $user->username ?></th>
                                    <th><?= $user->email ?></th>
                                    <th><?= $user->role ?></th>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>