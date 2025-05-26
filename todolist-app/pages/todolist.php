<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
require_once path('/lib/csrf.php');
require_once path('class/Post.php');
$user = 'root';
$password = 'root';
$user_id = $_SESSION['user_id'];
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
  $query = $pdo->query("SELECT * FROM posts WHERE user_id = $user_id");

  /**
   * @var Post[]
   */
  $posts = $query->fetchAll(PDO::FETCH_CLASS, 'Post');
} catch (PDOException $e) {
  $error = $e->getMessage();
}

require path('includes/elements/header.php');
?>

<h2>Liste des tâches</h2>
<a class="btn btn-success" href="/pages/create.php">Ajouter une tâche</a>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
  <?php foreach ($posts as $post): ?>
    <div class="d-flex align-items-center justify-content-between">
      <h2 class="mb-0"><?= htmlentities($post->name) ?></h2>
      <div>
        <a class="btn btn-secondary me-2" href="/pages/edit.php?id=<?= $post->id ?>">Éditer</a>
        <a class="btn btn-danger" href="/pages/delete.php?id=<?= $post->id ?>">Supprimer</a>
      </div>
    </div>
  <p class="small text-muted">Crée le <?= $post->getCreatedAt()->format('d/m/Y à H:i') ?></p>
  <p>
    <?= nl2br(htmlentities($post->getExcerpt())) ?>
  </p>
  <?php endforeach ?>
<?php endif ?>


<?php
require path('includes/elements/footer.php');
?>