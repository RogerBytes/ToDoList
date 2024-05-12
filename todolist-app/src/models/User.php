<?php

class User {
  public $id;
  public $name;
  public $email;
  public $password_hash;
  public $role;

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  private function validate_name($name) {
    if (empty($name)) {
      throw new InvalidArgumentException("Le nom ne peut pas être vide");
    }
    if (strlen($name) < 3 || strlen($name) > 30) {
      throw new InvalidArgumentException("Le nom doit faire entre 3 et 30 caractères");
    }
    if (!preg_match('/^[a-zA-Z\s\-]+$/', $name)) {
      throw new InvalidArgumentException("Le nom ne peut contenir que des lettres, des espaces et des tirets");
    }
  }

  private function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new InvalidArgumentException("L'adresse e-mail n'est pas valide.");
    }
  }

  private function validate_password($password) {
    if (strlen($password) < 8) {
      throw new InvalidArgumentException("Le mot de passe doit contenir au moins 8 caractères.");
    }
    if (!preg_match('/[A-Z]/', $password)) {
      throw new InvalidArgumentException("Le mot de passe doit contenir au moins une lettre majuscule.");
    }
    if (!preg_match('/[a-z]/', $password)) {
      throw new InvalidArgumentException("Le mot de passe doit contenir au moins une lettre minuscule.");
    }
    if (!preg_match('/\d/', $password)) {
      throw new InvalidArgumentException("Le mot de passe doit contenir au moins un chiffre.");
    }
    if (!preg_match('/[\W_]/', $password)) {
      throw new InvalidArgumentException("Le mot de passe doit contenir au moins un caractère spécial.");
    }
  }

  public function create_user($name, $email, $password, $role = 'standard') {
    $this->validate_name($name);
    $this->validate_email($email);
    $this->validate_password($password);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $password_hash, $role]);
    return $stmt->rowCount() > 0;
  }

  private function start_session_if_not_started() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  public function login($email, $password) {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
      session_start();
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['role'];
      return true;
    }
    return false;
  }

  public function logout() {
    session_start();
    session_unset();
    session_destroy();
  }

  public function find_by_id($id) {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update_user($id, $name, $email, $password, $role) {
    // Valider les données reçues
    $this->validate_name($name);
    $this->validate_email($email);
    $this->validate_password($password);

    // Hacher le mot de passe
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête SQL pour mettre à jour l'utilisateur
    $stmt = $this->pdo->prepare('UPDATE users SET name = ?, email = ?, password_hash = ?, role = ? WHERE id = ?');

    // Exécuter la requête avec les données validées et hachées
    $stmt->execute([$name, $email, $password_hash, $role, $id]);

    // Vérifier si l'utilisateur a été mis à jour
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      throw new Exception("La mise à jour de l'utilisateur a échoué ou aucune donnée n'a été modifiée.");
    }
  }

  private function is_admin() {
    if (!isset($_SESSION)) {
      session_start();
    }
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
  }

  public function delete_user($id) {
    // Préparer la requête SQL pour supprimer l'utilisateur
    $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');

    // Exécuter la requête avec l'identifiant fourni
    $stmt->execute([$id]);

    // Vérifier si l'utilisateur a été supprimé
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      throw new Exception("La suppression de l'utilisateur a échoué ou l'utilisateur n'existe pas.");
    }
  }

  public function list_users() {
    // Vérifier si l'utilisateur actuel est un administrateur
    if (!$this->is_admin()) {
      throw new Exception("Seul un administrateur peut accéder à la liste des utilisateurs.");
    }

    // Préparer la requête SQL pour sélectionner tous les utilisateurs
    $stmt = $this->pdo->query('SELECT id, name, email, role FROM users');

    // Récupérer et retourner les utilisateurs
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}