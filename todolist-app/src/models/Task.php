<?php
class Task {
  public $id;
  public $user_id;
  public $title;
  public $description;
  public $due_date;
  public $status;

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function create($user_id, $title, $description, $due_date, $status) {
    if (empty($title)) {
      throw new InvalidArgumentException('Le titre ne peut pas être vide.');
    }
    if (!in_array($status, ['open', 'in_progress', 'closed'])) {
      throw new InvalidArgumentException('Statut invalide.');
    }
    $due_date = date('Y-m-d', strtotime($due_date));
    $stmt = $this->pdo->prepare('INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, ?)');
    return $stmt->execute([$user_id, $title, $description, $due_date, $status]);
  }

  public function find_by_user_id($user_id) {
    $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC');
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_CLASS, 'Task');
  }

  public function update($id, $user_id, $title, $description, $due_date, $status) {
    if (empty($title)) {
      throw new InvalidArgumentException('Le titre ne peut pas être vide.');
    }
    if (!in_array($status, ['open', 'in_progress', 'closed'])) {
      throw new InvalidArgumentException('Statut invalide.');
    }
    $due_date = date('Y-m-d', strtotime($due_date));
    $stmt = $this->pdo->prepare('UPDATE tasks SET user_id = ?, title = ?, description = ?, due_date = ?, status = ? WHERE id = ?');
    return $stmt->execute([$user_id, $title, $description, $due_date, $status, $id]);
  }

  public function delete($id) {
    $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');
    return $stmt->execute([$id]);
  }
}