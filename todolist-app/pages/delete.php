<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
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
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $query->execute([

      'id' => (int)$_GET['id']
    ]);
    $success = 'Votre article a bien été supprimé';
  }
  $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
  $query->execute(['id' => (int)$_GET['id']]); // le get id est ce que retourne le get dans l'adresse http, avec le int je limite ce que peut mettre manuellement l'user dedans
  $post = $query->fetch(); // ici je ne fetch qu'une seule ligne, vu que via la query sql, j'ai une condition sur la clé unique de id
} catch (PDOException $e) {
  $error = $e->getMessage();
}

require path('includes/elements/header.php');
?>

<h2>Suppression d'une tâche</h2>


<?php if ($success): ?>
  <div class="alert alert-success"><?= $success ?>
  </div>
  <a href="/pages/todolist.php" class="btn btn-secondary">Retourner à la todolist</a>
<?php elseif ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
<h3><?= htmlentities($post->name) ?></h3>
<p><?= htmlentities($post->content) ?></p>
<form action="" method="post">
  <a href="/pages/todolist.php" class="btn btn-primary">Annuler la suppression</a>
  <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
</form>
<?php endif ?>

<?php
require path('includes/elements/footer.php');
?>