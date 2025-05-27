<?php

// Je suis à 37 minutes de la video chapitre 31
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
require_once path('class/Post.php');
$user = 'root';
$password = 'root';
// $user = $_ENV["DB_USER"];
// $password = $_ENV["DB_USER"];
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
$success = null;
try {
  if (isset($_POST['name'], $_POST['content'])) {
    $query = $pdo->prepare('INSERT INTO posts (name, content) VALUES (:name, :content)');
    $query->execute([
      'name' => $_POST['name'],
      'content' => $_POST['content']
    ]);
    header('Location: /pages/edit.php?id=' . $pdo->lastInsertId());
    exit();
  }
  $query = $pdo->query('SELECT * FROM posts');

  /**
   * @var Post[]
   */
  $posts = $query->fetchAll(PDO::FETCH_CLASS, 'Post');
} catch (PDOException $e) {
  $error = $e->getMessage();
}

require path('includes/elements/header.php');
?>

<h2>Bienvenu sur ToDoList.net !</h2>

<pre>
Des tâches, partout, tout le temps.
</pre>



<?php
require path('includes/elements/footer.php');
?>