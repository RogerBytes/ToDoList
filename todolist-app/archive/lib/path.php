<?php

// *dossier*/path.php
if (!defined('ROOT')) {
  define('ROOT', dirname(__DIR__));
}

function path(string $relPath): string {
  return ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);
}
