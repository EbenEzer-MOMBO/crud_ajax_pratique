<?php
require_once 'config.php';

class MySQLDatabase {
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct() {
        $this->host = DB_HOST;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->database = DB_NAME;
    }

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Vérifiez la connexion
        if ($this->connection->connect_error) {
            die("La connexion a échoué : " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function fetch_array($result){
        return $result->fetch_array();
    }

    public function close() {
        $this->connection->close();
    }

    public function escapeValue($text){
        return $this->connection->real_escape_string($text);
    }

    public function execute($query, $params = array()) {
        // Préparation de la requête
        $statement = $this->connection->prepare($query);

        if ($statement === false) {
            die("Erreur de préparation de la requête : " . $this->connection->error);
        }

        // Liaison des paramètres
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Supposant que tous les paramètres sont des chaînes
            $statement->bind_param($types, ...$params);
        }

        // Exécution de la requête
        $result = $statement->execute();

        if ($result === false) {
            die("Erreur lors de l'exécution de la requête : " . $statement->error);
        }

        // Fermeture du statement
        $statement->close();

        return $result;
    }

    public function fetchOne($query, $params = array()) {
        // Afficher la requête SQL
        echo "Requête SQL : $query\n";
    
        // Exécution de la requête avec des paramètres
        $this->execute($query, $params);
    
        // Récupération du résultat
        $result = $this->connection->store_result();
    
        if ($result === false) {
            die("Erreur lors de la récupération du résultat : " . $this->connection->error);
        }
    
        // Récupération de la première ligne de résultat
        $row = $result->fetch_assoc();
    
        // Libération des résultats
        $result->free();
    
        return $row;
    }
    
    
    

}
