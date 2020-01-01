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
                                    <th><a href="<?= $user->deleteUrl ?>"><i class="material-icons red-text">delete_forever</i></a></th>
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