<?php
session_start();
if($_SESSION['permission'] === 'admin'){
    require('../../php/user.functions.php');
    require('../../php/global.functions.php');
    require('../../public/php/pdo.php');

    $getAllUsers = $db->prepare('SELECT * FROM users');
    $getAllUsers->execute();
    while($user = $getAllUsers->fetch()){
        $getAllPoints = getAllPoints($user['id']);
        $updatePoints = $db->prepare('UPDATE users SET points = ? WHERE id = ?');
        $updatePoints->execute(array($getAllPoints, $user['id']));
        header('Location: ../?success=points');
    }
}else{
    header('Location: ../');
}
?>