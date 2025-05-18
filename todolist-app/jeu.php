<?php

$a_deviner = 150;
$title = "Jeu";
require "header.php"
?>




<div class="starter-template"></div>
<h1>Nombre mystère</h1>


<?php if ($_GET['chiffre'] > $a_deviner): ?>
  Votre chiffre est trop grand
<?php elseif ($_GET['chiffre'] < $a_deviner): ?>
  Votre chiffre est trop petit
<?php else: ?>
  Bravo, vous avez trouvé le chiffre
<?php endif; ?>



  <form action="/jeu.php" method="get">
    <input type="number" name="chiffre" placeholder="Entre 0 et 1000" value="<?= htmlentities($_GET['chiffre']) ?>">
    <input type="text" name="demo" value="test">
    <button type="submit">Deviner</button>
  </form>
</div>





<?php require "footer.php"; ?>