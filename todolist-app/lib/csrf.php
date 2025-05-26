<?php
session_start();
function csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function csrf_check(string $token): bool {
  return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}



/*




et dans la partie script

require_once path('/lib/csrf.php');
$local_token = csrf_token();

et dans la condition pour lancer mes requêtes, il faut insérer (derrière un &&)
csrf_check($_POST['csrf_token'])

il me faut ajouter un input caché dans mes formulaires
<input type="hidden" name="csrf_token" value="<?= $local_token ?>">


*/

?>
