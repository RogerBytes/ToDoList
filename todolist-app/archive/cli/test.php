<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'path.php';
require path('class/Form.php');

echo Form::checkbox('demo', 'Demo', []);
?>