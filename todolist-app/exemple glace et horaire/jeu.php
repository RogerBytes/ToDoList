<?php
require_once "functions.php";
//checkbox
$parfums = [
  "Fraise" => 4,
  "Vanille" => 3,
  "Chocolat" => 3
];

//radio
$cornets = [
  "Pot" => 2,
  "Cornet" => 3,
];

//checkbox
$supplements = [
  "Pépites de chocolat" => 1,
  "Chantilly" => .5
];

$title = "Composer votre Glace";
$ingredients = [];
$total = 0;

foreach (['parfum', 'supplement', 'cornet'] as $name) {
  if (isset($_GET[$name])) {
    $liste = $name . 's';
    $choix = $_GET[$name];
    if (is_array($choix)) {
      foreach ($choix as $value) {
        if (isset(${$liste}[$value])) {
          $ingredients[] = $value;
          $total += ${$liste}[$value];
        }
      }
    } else {
      if (isset(${$liste}[$choix])) {
        $ingredients[] = $choix;
        $total += ${$liste}[$choix];
      }
    }
  }
}




require "header.php";
?>




<div class="starter-template"></div>
<h1>Composer votre Glace</h1>


<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Votre Glace</h5>
        <ul>
          <?php foreach ($ingredients as $ingredient): ?>
            <li><?= $ingredient ?></li>
          <?php endforeach; ?>
        </ul>
        <p>
          <strong>Prix :</strong> <?= $total ?> €
        </p>
      </div>
    </div>


  </div>
  <div class="col-md-8">
    <form action="/jeu.php" method="get">
      <h2>Choisissez vos parfums</h2>
      <?php foreach ($parfums as $parfum => $prix): ?>
        <div class="checkbox">
          <label>
            <?= checkbox('parfum', $parfum, $_GET); ?>
            <?= $parfum ?> - <?= $prix ?>€
          </label>
        </div>
      <?php endforeach; ?>
      <h2>Choisissez votre cornet</h2>
      <?php foreach ($cornets as $cornet => $prix): ?>
        <div class="checkbox">
          <label>
            <?= radio('cornet', $cornet, $_GET); ?>
            <?= $cornet ?> - <?= $prix ?>€
          </label>
        </div>
      <?php endforeach; ?>
      <h2>Choisissez vos suppléments</h2>
      <?php foreach ($supplements as $supplement => $prix): ?>
        <div class="checkbox">
          <label>
            <?= checkbox('supplement', $supplement, $_GET); ?>
            <?= $supplement ?> - <?= $prix ?>€
          </label>
        </div>
      <?php endforeach; ?>
      <button class="btn btn-primary">Composer ma glace</button>
    </form>
  </div>
</div>



<h3>Prix</h3>
<h2> GET</h2>
<!-- [DEBUG] -->
<pre><?php var_dump($_GET); /* print_r($_GET); */ /* echo var_export($_GET, true); */ ?></pre>

<h2>POST</h2>
<!-- [DEBUG] -->
<pre><?php var_dump($_POST); /* print_r($_POST); */ /* echo var_export($_POST, true); */ ?></pre>


<?php require "footer.php"; ?>