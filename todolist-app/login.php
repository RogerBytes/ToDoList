<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
$erreur= null;
$password = '$2y$14$QcdbyR05QtNWbsWqjpqQZeB2oXJ2ITMv4ltYNmUPHLm1Oqp5qLJFK';
if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
  if ($_POST['pseudo'] === 'John' && password_verify($_POST['password'], $password)) {
    session_start();
    $_SESSION['user_id'] = 1;
    header("Location: /dashboard.php");
  } else {
    $erreur = "Identifiants incorrects";
  }
}

require_once path('functions/auth.php');

if (is_connected()){
  header('Location: /dashboard.php');
  exit();
}

require_once path("elements/header.php");
?>

<?php if($erreur): ?>
<div class="alert alert-danger">
  <?= $erreur ?>
</div>
<?php endif ?>

<form action="" method="post">
  <div class="form-group">
    <input class="form-control" type="text" name="pseudo" placeholder="Nom d'utilisateur">
  </div>
  <div class="form-group">
    <input class="form-control" type="password" name="password" placeholder="Votre mot de passe">
  <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<?php require path("elements/footer.php"); ?>