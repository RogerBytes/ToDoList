<?php


$host = 'mysql';
$dbname = 'todolist';
$user = 'root';
$pass = 'root';

// Options de connexion à la base de données
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active le rapport d'erreurs sous forme d'exceptions
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Définit le mode de récupération par défaut en tant que tableau associatif
  PDO::ATTR_EMULATE_PREPARES => false, // Désactive l'émulation des requêtes préparées
];

// Chaîne DSN pour PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
  // Création de l'instance PDO
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  // Gestion des erreurs de connexion
  error_log("Erreur de connexion à la base de données : " . $e->getMessage());
  exit('Erreur de connexion à la base de données.');
}