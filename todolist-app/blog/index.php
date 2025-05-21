<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
$user = 'root';
$password = 'root';
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password);


require path('includes/elements/header.php');
?>

<h2>Coucou c'est nous</h2>

<?php
require path('includes/elements/footer.php');
?>