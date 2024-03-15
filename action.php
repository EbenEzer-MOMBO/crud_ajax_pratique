<?php

require_once 'incl/db.php';
require_once 'class/utilisateur.php';
require_once 'class/ecole.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $ecole = new Ecole();

        // connexion
        if ($action == "connexion") {
            // Récupérer les données du formulaire
            $username = $_POST['con_email'];
            $password = $_POST['con_passwd'];

            // Instancier la classe Utilisateur et appeler la méthode de connexion
            $user = new Utilisateur();
            $user->connexion($username, $password);
        }

        // inscription
        elseif ($action == "inscription") {
            // Récupérer les données du formulaire
            $name = $_POST['ins_nom'];
            $username = $_POST['ins_email'];
            $password = $_POST['ins_passwd'];

            // Instancier la classe Utilisateur et appeler la méthode de connexion
            $user = new Utilisateur();
            $user->inscription($name, $username, $password);
        }

        // deconnexion
        elseif ($action == "deconnexion") {
            $user = new Utilisateur();
            $user->deconnexion();
        }

        // ajouter classe
        elseif ($action == "ajouterClasse") {
            $libelle = $_POST['libelle'];
            $ecole->ajouterClasse($libelle);
        }

        // modifier classe
        elseif ($action == "modifierClasse") {
            $id_classe = $_POST['id_classe'];
            $nouveauLibelle = $_POST['libelle'];
            $ecole->modifierClasse($id_classe, $nouveauLibelle);
        }

        // supprimer classe
        elseif($action == "supprimerClasse"){
            $id_classe = $_POST['delete_id'];
            $ecole->supprimerClasse($id_classe);
        }

        // ajouter eleve
        elseif($action == "ajouterEleve"){
            $nom = $_POST['nom'];
            $classe = $_POST['id_classe'];
            $ecole->ajouterEleve($nom, $classe);
        }

        // modifier eleve
        elseif($action == "modifierEleve"){
            $id = $_POST['id_eleve'];
            $nouveauNom = $_POST['nom'];
            $nouvelleClasse = $_POST['id_classe'];
            $ecole->modifierEleve($id, $nouveauNom, $nouvelleClasse);
        }

        // supprimer eleve
        elseif($action == "supprimerEleve"){
            $id = $_POST['delete_id'];
            $ecole->supprimerEleve($id);
        }
        
        else {
            echo "Aucun cas";
        }
    } else {
        echo "Aucune action";
    }
}
