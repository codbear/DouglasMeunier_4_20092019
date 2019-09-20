<div class="navbar-fixed">
    <nav class="teal">
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo">Un billet pour l'Alaska</a>
            <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/">Accueil</a></li>
                <li><a href="#">Lire</a></li>
				<?php if((isset($_SESSION['isConnected'])) && ($_SESSION['isConnected'])) { ?>
				<li><a href="?view=login&action=logout">Se déconnecter</a></li>
				<?php } else { ?>
                <li><a href="?view=login">Se connecter / S'inscrire</a></li>
				<?php } ?>
            </ul>
        </div>
    </nav>
</div>
