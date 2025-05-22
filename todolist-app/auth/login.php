<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
$erreur= null;
// le mdp est John

$password = '$2y$10$xXSmFI/LcQXRBY/gAveJQeY2ShjbFaqvkK.cnPJ1DgWa3Bxebco9O';

if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
  if ($_POST['pseudo'] === 'John' && password_verify($_POST['password'], $password)) {
    session_start();
    $_SESSION['user_id'] = 1;
    header("Location: /index.php");
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