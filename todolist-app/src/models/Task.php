<?php

class Task {
  private $pdo;
  private $id;
  private $title;
  private $description;
  private $status;
  private $user_id;
  private $due_date;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function set_id($id) {
    $this->id = $id;
  }

  public function set_title($title) {
    $this->title = $title;
  }

  public function set_description($description) {
    $this->description = $description;
  }

  public function set_status($status) {
    $this->status = $status;
  }

  public function set_user_id($user_id) {
    $this->user_id = $user_id;
  }

  public function set_due_date($due_date) {
    $this->due_date = $due_date;
  }

  public function save() {
    try {
      $this->validate();

      if ($this->id === null) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (title, description, status, user_id, due_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->title, $this->description, $this->status, $this->user_id, $this->due_date]);
        $this->id = $this->pdo->lastInsertId();
      } else {
        $stmt = $this->pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, user_id = ?, due_date = ? WHERE id = ?");
        $stmt->execute([$this->title, $this->description, $this->status, $this->user_id, $this->due_date, $this->id]);
      }
    } catch (Exception $e) {
      error_log($e->getMessage());
      throw $e;
    }
  }

  private function validate() {
    if (empty($this->title)) {
      throw new Exception("Le titre ne peut pas être vide.");
    }
    // Ajouter d'autres règles de validation ici
  }

  public function get_id() {
    return $this->id;
  }

  public function get_title() {
    return $this->title;
  }

  public function get_description() {
    return $this->description;
  }

  public function get_status() {
    return $this->status;
  }

  public function get_user_id() {
    return $this->user_id;
  }

  public function get_due_date() {
    return $this->due_date;
  }

  public function delete() {
    if ($this->id !== null) {
      $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");
      $stmt->execute([$this->id]);
    }
  }

  public static function find_by_id($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Task');
    return $stmt->fetch();
  }

  // ... autres méthodes métier ...
}

?>