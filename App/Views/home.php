<?php ob_start();?>
		<div id="jumbotron" class="row">
            <img src="/img/jumbotron.jpeg" alt="">
        </div>

            <div id="book-excerpt" class="row blue-grey darken-3 white-text">
                <div class="col s6 offset-s3">
                    <p>
                        Jean Forteroche nous livre le récit de son voyage vers l'Alaska à bord du Graf Zeppelin. Alors journaliste au Matin, seul français à bord,
                        il faisait partie de ces quelques privilégiés conviés pour ce vol inaugural.l nous décrit les différentes étapes du vol: décollage d'Allemagne,
                        survol de Berlin, survol de la Russie et de ses immensités inhospitalières, escale à Tokyo où 200000 spectateurs acclament le majestueux vaisseau
                        lors de son atterrissage. Le dirigeable effectue alors la première traversée du Pacifique, traversant l'orage le plus violent qu'ai vécut Hugo Eckener,
                        commandant de Bord, totalisant alors plus de 3000 vols en dirigeable, considéré à raison comme le Maître en la matière. 8673 km plus loin, il survole
                        la baie San Francisco et va se poser à Los Angeles pour une nouvelle escale avant de rejoindre Anchorage en Alaska.
                    </p>
                </div>
            </div>
            <div id="author-presentation" class="row">

            </div>
        </div>
<?php $content = ob_get_clean() ?>

<?php require_once('template.php'); ?>
