<?php

use Composer\Command\FundCommand;


function nav_item(string $script_name, string $title, string $link_class = ''): string {
  $class = 'nav-item';
  if ($_SERVER['SCRIPT_NAME'] === $script_name) {
    $class .= ' active';
  }
  return <<<EOC
<li class="$class">
  <a class="$link_class" href="$script_name">$title</a>
</li>
EOC;
}

function nav_menu(string $class = ''): string {
  return
    nav_item("/index.php", "Accueil", $class) .
    nav_item("/jeu.php", "Jeu", $class) .
    nav_item("/contact.php", "Contact", $class);
}


function checkbox(string $name, string $value, array $data): string {
  $attribute = '';
  if (isset($data[$name]) && in_array($value, $data[$name])) {
    $attribute .= 'checked';
  }
  return <<<HTML
  <input type="checkbox" name="{$name}[]" value="$value" $attribute>
HTML;
}


function radio(string $name, string $value, array $data): string {
  $attribute = '';
  if (isset($data[$name]) && $value === $data[$name]) {
    $attribute .= 'checked';
  }
  return <<<HTML
  <input type="radio" name="{$name}" value="$value" $attribute>
HTML;
}

function dump($var) {
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
}

function creneaux_html(array $creneaux): string {
  if (empty($creneaux)) {
    return "Fermé";
  }
  $phrases = [];
  foreach ( $creneaux as $creneau ) {
    $phrases[] = "de <strong>{$creneau[0]}h à {$creneau[1]}h</strong>";
  }
  return "Ouvert " . implode(" et ", $phrases);
}