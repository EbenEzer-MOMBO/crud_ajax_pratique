<div class="container">
    <div class="row px-4 pt-4">
        <h1 class="title">Accueil</h1>
    </div>
</div>

<?php

require_once 'class/ecole.php';

// Instanciation de la classe Ecole
$ecole = new Ecole();
?>

<div class="container">
    <div class="row px-4 pt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Classe</h5>
                    <p class="card-text"> <span id="classCount"><?php echo $ecole->nbrClasses(); ?></span></p>
                </div>
                <img src="assets/icons8-classe-96.png" class="float-end" alt="Image" width="100px">
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Élève</h5>
                    <p class="card-text"> <span id="classCount"><?php echo $ecole->nbrEleves(); ?></span></p>
                </div>
                <img src="assets/icons8-camarades-de-classe-debout-peau-type-4-96.png" class="float-end" alt="Image" width="100px">
            </div>
        </div>

        <!-- <div class="col-md-6 pt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Paiements</h5>
                    <p class="card-text"> <span id="classCount"><?php //echo $ecole->getTotalPaiements(); ?> Fcfa</span></p>
                </div>
                <img src="assets/icons8-performance-de-ventes-96.png" class="float-end" alt="Image" width="100px">
            </div>
        </div> -->

    </div>
</div>