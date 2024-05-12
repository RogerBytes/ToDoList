<?php

class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $tasks = [];

    public function __construct($id = null, $name = '', $email = '', $password = '') {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }

    public function getTasks() {
        // Implémentez la logique pour récupérer les tâches de la base de données
        return $this->tasks;
    }

    public function save() {
        // Implémentez la logique pour sauvegarder l'utilisateur dans la base de données
    }

    public function update() {
        // Implémentez la logique pour mettre à jour l'utilisateur dans la base de données
    }

    public function delete() {
        // Implémentez la logique pour supprimer l'utilisateur de la base de données
    }

    public static function find($id) {
        // Implémentez la logique pour trouver un utilisateur par son ID
    }

    public static function findByEmail($email) {
        // Implémentez la logique pour trouver un utilisateur par son email
    }

    public static function all() {
        // Implémentez la logique pour récupérer tous les utilisateurs
    }

    public function validate() {
        // Implémentez la validation des données de l'utilisateur ici
    }

    public static function login($email, $password) {
        // Implémentez la logique de connexion ici
    }

    public static function logout() {
        // Implémentez la logique de déconnexion ici
    }

    public static function register($name, $email, $password) {
        // Implémentez la logique d'inscription ici
    }

    public function hashPassword() {
        // Implémentez le hashage du mot de passe ici
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        // Implémentez la vérification du mot de passe ici
        return password_verify($password, $this->password);
    }

    public function changePassword($oldPassword, $newPassword) {
        // Implémentez le changement de mot de passe ici
    }

    public static function sendPasswordReset($email) {
        // Implémentez l'envoi de l'email de réinitialisation de mot de passe ici
    }

    public function resetPassword($newPassword) {
        // Implémentez la réinitialisation du mot de passe ici
    }

}

?>