<?php
session_start();
if(isset($_POST['share'])){
    require('../public/php/pdo.php');
    $shared = $db->prepare('SELECT * FROM share WHERE (publication = ? AND shared = ?)');
    $shared->execute(array($_POST['id'],$_SESSION['id']));
    $hasShared = $shared->rowCount();
    if($hasShared > 0){
        $unShare = $db->prepare('DELETE FROM share WHERE publication = ? AND shared = ?');
        $unShare->execute(array($_POST['id'],$_SESSION['id']));
        $deleteNotification = $db->prepare('DELETE FROM notifications WHERE publication = ? AND share = ?');
        $deleteNotification->execute(array($_POST['id'], $_SESSION['id']));
        exit('unShared');
    }else{
        $share = $db->prepare('INSERT INTO share (publication,shared) VALUES (?,?)');
        $share->execute(array($_POST['id'],$_SESSION['id']));
        $notify = $db->prepare('INSERT INTO notifications (share,publication) VALUES (?,?)');
        $notify->execute(array($_SESSION['id'],$_POST['id']));
        exit('shared');
    }
}
?>