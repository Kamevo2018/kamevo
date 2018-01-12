<?php
session_start();
if(isset($_POST['see'])){
    require('../public/php/pdo.php');
    $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
    $getPublications->execute(array($_SESSION['id']));
    $countPublications = $getPublications->rowCount();
    $publications = $getPublications->fetchAll();
    $getAllNotifications = $db->prepare('UPDATE notifications SET seen = 1 WHERE (publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')) OR (profile = ?)');
    $getAllNotifications->execute(array($_SESSION['id']));
    exit('seen');
}
?>