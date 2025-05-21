<?php
session_start();
unset($_SESSION["role"]);
$title = "Page d'accueil";
require "elements/header.php"
  ?>

<div class="starter-template">
  <h1>Bootstrap starter template</h1>
  <p class="lead">J'en suis au chapitre 14 "Les dates"</p>
</div>
<?= $password = password_hash("Doe", PASSWORD_DEFAULT, ['cost' => 14]); ?>

<!-- [DEBUG] --><pre><?php var_dump(password_verify("Doe", '$2y$14$QcdbyR05QtNWbsWqjpqQZeB2oXJ2ITMv4ltYNmUPHLm1Oqp5qLJFK')); /* print_r(password_verify("Doe, "")); */ /* echo var_export(password_verify("Doe, ""), true); */ ?></pre>

<?php require "elements/footer.php"; ?>