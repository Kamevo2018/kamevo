<?php
session_start();
if(isset($_POST['user'])){
    require('../../public/php/pdo.php');
    $isSub = $db->prepare('SELECT * FROM subs WHERE profile = ? AND subscriber = ?');
    $isSub->execute(array(htmlspecialchars($_POST['user']),htmlspecialchars($_SESSION['id'])));
    $ifSub = $isSub->rowCount();
    if($ifSub == 0){
        $sub = $db->prepare('INSERT INTO subs (profile,subscriber) VALUES (?,?)');
        $sub->execute(array(htmlspecialchars($_POST['user']), htmlspecialchars($_SESSION['id'])));
        $notify = $db->prepare('INSERT INTO notifications (subscribe,profile) VALUES (?,?)');
        $notify->execute(array(htmlspecialchars($_SESSION['id']), htmlspecialchars($_POST['user'])));
        exit('subed');
    }else{
        $unsub = $db->prepare('DELETE FROM subs WHERE profile = ? AND subscriber = ?');
        $unsub->execute(array(htmlspecialchars($_POST['user']), htmlspecialchars($_SESSION['id'])));
        $deleteNotification = $db->prepare('DELETE FROM notifications WHERE subscribe= ? AND profile = ?');
        $deleteNotification->execute(array(htmlspecialchars($_SESSION['id']),htmlspecialchars($_POST['user'])));
        exit('unsubed');
    }
}
?>