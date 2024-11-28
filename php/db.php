<?php
$host = "localhost"; // ou l'adresse de ton serveur MySQL
$user = "root"; // ton nom d'utilisateur MySQL
$password = ""; // ton mot de passe MySQL
$database = "petition_db"; // le nom de ta base de données

// Créer la connexion
$conn = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

