<?php
session_start();
$title = "Nous contacter";
require_once "config.php";
require_once "functions.php";
require "header.php";
?>

<div class="row">
  <div class="col-md-8">
    <h2>Nous contacter</h2>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatum, quam in! Maiores</p>
  </div>
  <div class="col-md-4">
    <h2>Horaires d'ouverture</h2>
    <?= date('l') ?>
    <ul>
    <?php foreach (JOURS as $key => $jour): ?>
      <li>
        <strong><?= $jour ?></strong> :
        <?= creneaux_html(CRENEAUX[$key]) ?>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
</div>

<?php require "footer.php"; ?>