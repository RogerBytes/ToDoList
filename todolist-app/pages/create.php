<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
require_once path('/lib/csrf.php');
$local_token = csrf_token();
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
  if (isset($_POST['name'], $_POST['content']) && csrf_check($_POST['csrf_token'])) {
    $query = $pdo->prepare('INSERT INTO posts (name, content) VALUES (:name, :content)');
    $query->execute([
      'name' => $_POST['name'],
      'content' => $_POST['content']
    ]);
    $success = 'Votre tâche a bien été ajoutée';
  }

} catch (PDOException $e) {
  $error = $e->getMessage();
}

require path('includes/elements/header.php');
?>


<h2>Créer une tâche</h2>


<?php if ($success): ?>
  <div class="alert alert-success"><?= $success ?>
  </div>
  <a href="/pages/todolist.php" class="btn btn-secondary">Retourner à la todolist</a>
<?php elseif ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
  <form action="" method="post">
  <div class="form-group">
    <input type="hidden" name="csrf_token" value="<?= $local_token ?>">
    <input type="text" class="form-control" name="name" placeholder="Nom de la tâche">
  </div>
  <div class="form-group">
    <textarea class="form-control" name="content" placeholder="Contenu de la tâche"></textarea>
  </div>
  <a href="/pages/todolist.php" class="btn btn-secondary">Annuler la nouvelle tâche</a>
  <button class="btn btn-primary">Confirmer la tâche</button>
</form>
<?php endif ?>

<?php
require path('includes/elements/footer.php');
?>