<?php
require_once 'class/ecole.php';

// Instanciation de la classe Ecole
$ecole = new Ecole();

// Récupérer les eleves de l'école depuis la base de données
$eleves = $ecole->getEleves();

// Convertir les données en format JSON
echo json_encode($eleves);

