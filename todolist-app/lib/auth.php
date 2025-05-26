<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
// Attention, il faut passer la fonction is_connected() dans une variable AVANT qu'il y ait du HTML; comme cela on peut appeler la variable en plein milieu de la page

function is_connected(): bool {
  return !empty($_SESSION['user_id']);
}

function req_connect ():void {
  if (!is_connected()) {
    header("Location: /auth/login.php");
    exit;
  }
}

?>