<?php
$dsn = 'mysql:dbname=kamevo;host=localhost';
$user = 'root';
$password = '3VqF;wc=K.57w*7C3e]D';
try {
    $db = new PDO($dsn, $user, $password,  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Mysql issue :' . $e->getMessage();
}
?>