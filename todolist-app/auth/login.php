<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
require_once path('/lib/csrf.php');
$local_token = csrf_token();
$erreur= null;
// le mdp est John

$db_user = 'root';
$db_password = 'root';
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $db_user, $db_password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

if (!empty($_POST['pseudo']) && !empty($_POST['password']) && csrf_check($_POST['csrf_token'])) {
  $query = $pdo->prepare('SELECT * FROM users WHERE username = :username');
  $query->execute(['username' => $_POST['pseudo']]);
  $user = $query->fetch();

  if ($user && password_verify($_POST['password'], $user->password_hash)) {
    $_SESSION['user_id'] = $user->id;
    header("Location: /pages/todolist.php");
    exit();
  } else {
    $erreur = "Identifiants incorrects";
  }
}

require_once path('lib/auth.php');

if (is_connected()){
  header('Location: /index.php');
  exit();
}

require_once path("includes/elements/header.php");
?>

<?php if($erreur): ?>
<div class="alert alert-danger">
  <?= $erreur ?>
</div>
<?php endif; ?>

<form action="" method="post">
  <input type="hidden" name="csrf_token" value="<?= $local_token ?>">
  <div class="form-group">
    <input class="form-control" type="text" name="pseudo" placeholder="Nom d'utilisateur">
  </div>
  <div class="form-group">
    <input class="form-control" type="password" name="password" placeholder="Votre mot de passe">
    <br>
    <button type="submit" class="btn btn-primary">Se connecter</button>
  </div>
</form>

<?php
require_once path("includes/elements/footer.php");
?>