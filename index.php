<?php
$c = $_GET['c'] ?? 'book';
$a = $_GET['a'] ?? 'index';

$controllerName = ucfirst($c) . 'Controller';
$path = "controllers/$controllerName.php";

require_once $path;
$controller = new $controllerName();
$controller->$a();
