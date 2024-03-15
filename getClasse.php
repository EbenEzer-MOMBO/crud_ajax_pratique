<?php
require_once 'class/ecole.php';

// Instanciation de la classe Ecole
$ecole = new Ecole();

// Récupérer les classes de l'école depuis la base de données
$classes = $ecole->getClasses();

// Convertir les données en format JSON
echo json_encode($classes);

