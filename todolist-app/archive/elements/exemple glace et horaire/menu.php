<?php

if (!function_exists('nav_item')) {
  function nav_item(string $script_name, string $title, string $link_class= ''): string
  {
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
}
?>

<?= nav_item("/index.php", "Accueil", $class) ?>
<?= nav_item("/contact.php", "Contact", $class) ?>