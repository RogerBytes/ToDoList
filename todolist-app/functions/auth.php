<?php

function is_connected(): bool {
  return !empty($_SESSION['connected']);
}

?>