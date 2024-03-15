<?php

class Utilisateur
{
    private $db;

    public function __construct()
    {
        $this->db = new MySQLDatabase();
        $this->db->connect();
    }

    // inscription
    public function inscription($nom, $email, $password) {
        // Échapper les valeurs pour éviter les injections SQL
        $nom = $this->db->escapeValue($nom);
        $email = $this->db->escapeValue($email);
    
        // Vérifier si l'e-mail existe déjà
        $existingUserQuery = "SELECT * FROM utilisateur WHERE u_email = '$email'";
        $existingUserResult = $this->db->query($existingUserQuery);
    
        if ($existingUserResult && $existingUserResult->num_rows > 0) {
            // L'e-mail existe déjà dans la base de données, renvoyer une erreur
            echo 'emailExists';
            return false;
        } else {
            // L'e-mail n'existe pas encore, continuer avec l'inscription
    
            // Hacher le mot de passe
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
            // Construire la requête SQL pour l'inscription
            $query = "INSERT INTO utilisateur (u_nom, u_email, u_passwd) VALUES ('$nom', '$email', '$passwordHash')";
    
            // Exécuter la requête SQL
            $result = $this->db->query($query);
    
            // Vérifier si l'insertion a réussi
            if ($result) {
                echo 'successIns';
                return true;
            } else {
                echo 'errorIns';
                return false;
            }
        }
    }
    
    // connexion
    public function connexion($email, $password) {
        // Échapper les valeurs pour éviter les injections SQL
        $email = $this->db->escapeValue($email);
        
        // Rechercher l'utilisateur dans la base de données en fonction de l'email
        $query = "SELECT * FROM utilisateur WHERE u_email = '$email'";
        $result = $this->db->query($query);
    
        if ($result && $result->num_rows > 0) {
            $user = $this->db->fetch_array($result);
    
            // Vérifier si le mot de passe haché correspond au mot de passe fourni
            if (password_verify($password, $user['u_passwd'])) {
                session_start();
                $_SESSION['message'] = "Bon retour!";
                $_SESSION['connecte'] = true;
                // header("Location: index.php");
                return true;
            } else {
                // $_SESSION['message'] = "Mot de passe incorrect.";
                echo 'errorCon';
                return false;
            }
        } else {
            // $_SESSION['message'] = "Aucun utilisateur trouvé avec cet email.";
            echo 'errorCon';
            return false;
        }
    }

    // deconnexion
    public function deconnexion(){
        $_SESSION["connecte"] = false;
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
}
