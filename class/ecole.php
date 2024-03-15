<?php
require_once 'incl/db.php';

class Ecole
{
    private $db;

    public function __construct()
    {
        $this->db = new MySQLDatabase();
        $this->db->connect();
    }

    // nombre de classes
    public function nbrClasses()
    {
        $query = "SELECT COUNT(*) as count FROM classe";
        $result = $this->db->query($query);

        // Vérifiez si la requête a réussi
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return false;
        }
    }

    // nombre d'élèves
    public function nbrEleves()
    {
        $query = "SELECT COUNT(*) as count FROM eleve";
        $result = $this->db->query($query);

        // Vérifiez si la requête a réussi
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return false;
        }
    }

    // total paiement
    public function getTotalPaiements()
    {
        $query = "SELECT SUM(montant) AS total FROM paiement";
        $result = $this->db->query($query);
        $total = $result->fetch_assoc()['total'];
        return $total;
    }

    // afficher les classes
    public function getClasses()
    {
        $query = "SELECT * FROM classe";
        $result = $this->db->query($query);

        if ($result) {
            $classes = array();

            // Parcourir les résultats
            while ($row = $result->fetch_assoc()) {
                $classes[] = $row;
            }

            // Libérer le résultat
            $result->free();

            return $classes;
        } else {
            // Gérer l'erreur si la requête a échoué
            return false;
        }
    }

    // ajouter une classe
    public function ajouterClasse($libelle)
    {
        $sql = "INSERT INTO classe (libelle) VALUES ('$libelle')";
        $result = $this->db->query($sql);

        if ($result) {
            echo 'true';
            return true;
        } else {
            return true;
        }
    }

    // modifier une classe
    public function modifierClasse($id, $nouveauLibelle)
    {
        $sql = "UPDATE classe SET libelle = '$nouveauLibelle' WHERE id = '$id'";
        $result = $this->db->query($sql);

        if ($result) {
            echo 'true';
            return true;
        } else {
            return false;
        }
    }

    // supprimer une classe
    public function supprimerClasse($id)
    {
        $sql = "DELETE FROM classe WHERE id = '$id'";
        $result = $this->db->query($sql);

        if ($result) {
            //header("Location: index.php");
            echo 'true';
            return true;
        } else {
            return false;
        }
    }

    // afficher les eleves
    public function getEleves()
    {
        $query = "SELECT eleve.id, nom, classe.libelle, eleve.statut FROM eleve join classe on eleve.id_classe = classe.id";
        $result = $this->db->query($query);

        if ($result) {
            $eleves = array();

            // Parcourir les résultats
            while ($row = $result->fetch_assoc()) {
                $eleves[] = $row;
            }

            // Libérer le résultat
            $result->free();

            return $eleves;
        } else {
            // Gérer l'erreur si la requête a échoué
            return false;
        }
    }

    // ajouter un eleve
    public function ajouterEleve($nom, $classe)
    {
        $sql = "INSERT INTO eleve (nom, id_classe) VALUES ('$nom', $classe)";
        $result = $this->db->query($sql);

        if ($result) {
            //header("Location: index.php");
            echo 'true';
            return true;
        } else {
            return false;
        }
    }

    // modifier une classe
    public function modifierEleve($id, $nouveauNom, $idClasse)
    {
        $sql = "UPDATE eleve SET nom = '$nouveauNom', id_classe = '$idClasse' WHERE id = '$id'";
        $result = $this->db->query($sql);

        if ($result) {
            echo 'true';
            return true;
        } else {
            return false;
        }
    }

    // supprimer un eleve
    public function supprimerEleve($id)
    {
        $sql = "DELETE FROM eleve WHERE id = '$id'";
        $result = $this->db->query($sql);

        if ($result) {
            //header("Location: index.php");
            echo 'true';
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour valider ou annuler le paiement d'un élève
    public function validerPaie($eleve_id)
    {
        // Récupérer le statut actuel de l'élève
        $current_statut = $this->getEleveStatut($eleve_id);

        // Mettre à jour le statut de l'élève
        if ($current_statut == 0) {
            $new_statut = 1;
            $this->ajouterElevePaiement($eleve_id);
        } else {
            $new_statut = 0;
            $this->supprimerElevePaiement($eleve_id);
        }

        // Mettre à jour le statut dans la base de données
        $query = "UPDATE eleve SET statut = $new_statut WHERE id = $eleve_id";
        $result = $this->db->query($query);

        // Vérifie si la mise à jour a réussi
        if ($result) {
            header("Location: index.php");
            return $new_statut;
        } else {
            return false;
        }
    }

    // Méthode pour récupérer le statut d'un élève
    private function getEleveStatut($eleve_id)
    {
        $query = "SELECT statut FROM eleve WHERE id = $eleve_id";
        $result = $this->db->query($query);
        $row = $this->db->fetch_array($result);
        return $row['statut'];
    }

    // ajouter l'eleve à la liste de paiements
    public function ajouterElevePaiement($id_eleve)
    {
        $sql = "INSERT INTO paiement (id_eleve, montant) VALUES ('$id_eleve', 150000)";
        $result = $this->db->query($sql);
        return $result;
    }

    // retirer l'eleve des paiements
    public function supprimerElevePaiement($id)
    {
        $sql = "DELETE FROM paiement WHERE id_eleve = '$id'";
        $result = $this->db->query($sql);
        return $result;
    }

    // afficher les paiements
    public function afficherPaiements()
    {
        $query = "SELECT paiement.id, paiement.montant, paiement.date, eleve.nom FROM paiement JOIN eleve ON paiement.id_eleve = eleve.id";
        $result = $this->db->query($query);

        if ($result) {
            $paiements = array();

            // Parcourir les résultats
            while ($row = $result->fetch_assoc()) {
                $paiements[] = $row;
            }

            // Libérer le résultat
            $result->free();

            return $paiements;
        } else {
            // Gérer l'erreur si la requête a échoué
            return false;
        }
    }
}
