<?php
function getConnection() {
    // Charger la configuration
    $config = require "config.php";

    try {
        // Connexion PDO
        $pdo = new PDO(
            "mysql:host=" . $config["host"] . ";dbname=" . $config["dbname"],
            $config["username"],
            $config["password"],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        return $pdo;

    } catch (PDOException $e) {

        // Enregistrer l'erreur dans un fichier log
        file_put_contents(
            "db_errors.log",
            date("Y-m-d H:i:s") . " - ERROR: " . $e->getMessage() . "\n",
            FILE_APPEND
        );

        // Retour propre
        return false;
    }
}
