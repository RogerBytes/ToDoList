<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
$user = 'root';
$password = 'root';
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
try
{
  $query = $pdo->query('SELECT * FROM posts');
  $posts = $query->fetchAll();
}
catch (PDOException $e)
{
  $error = $e->getMessage();
}






require path('includes/elements/header.php');
?>

<h2>Coucou c'est nous</h2>


<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
  <ul>
  <?php foreach ($posts as $post): ?>
  <li><?= $post->name?></li>
  <?php endforeach ?>
</ul>
<?php endif ?>


<?php
require path('includes/elements/footer.php');
?>