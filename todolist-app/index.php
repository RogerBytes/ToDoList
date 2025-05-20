<?php
session_start();
$_SESSION['role'] = 'administrateur';
$title = "Page d'accueil";
require "elements/header.php"
  ?>

<div class="starter-template">
  <h1>Bootstrap starter template</h1>
  <p class="lead">J'en suis au chapitre 14 "Les dates"</p>
</div>

<?php require "elements/footer.php"; ?>