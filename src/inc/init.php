<?php 

$bdd = new PDO('mysql:host=localhost;dbname=wf3_php_intermediaire_abdellah', 'root','',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

session_start();

foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlentities($value);
}

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlentities($value);
}

require_once('function.php');
require_once('validate.php');