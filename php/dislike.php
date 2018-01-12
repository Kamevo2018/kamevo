<?php
session_start();
if(isset($_POST['dislike'])){
    require('../public/php/pdo.php');
    $disliked = $db->prepare('SELECT * FROM dislikes WHERE (publication = ? AND disliker = ?)');
    $disliked->execute(array($_POST['id'], $_SESSION['id']));
    $hasDisliked = $disliked->rowCount();
    if($hasDisliked > 0){
        $unDislike = $db->prepare('DELETE FROM dislikes WHERE publication = ? AND disliker = ?');
        $unDislike->execute(array($_POST['id'], $_SESSION['id']));
        $deleteNotification = $db->prepare('DELETE FROM notifications WHERE publication = ? AND vote = ?');
        $deleteNotification->execute(array($_POST['id'], $_SESSION['id']));
        exit('unDisliked');
    }else{
        $liked = $db->prepare('SELECT * FROM likes WHERE publication = ? AND liker = ?');
        $liked->execute(array($_POST['id'], $_SESSION['id']));
        $hasLiked = $liked->rowCount();
        if($hasLiked > 0){
            $unLike = $db->prepare('DELETE FROM likes WHERE publication = ? AND liker = ?');
            $unLike->execute(array($_POST['id'], $_SESSION['id']));
            $dislike = $db->prepare('INSERT INTO dislikes (publication,disliker) VALUES (?,?)');
            $dislike->execute(array($_POST['id'], $_SESSION['id']));
        }else{
            $dislike = $db->prepare('INSERT INTO dislikes (publication,disliker) VALUES (?,?)');
            $dislike->execute(array($_POST['id'], $_SESSION['id']));
            $notify = $db->prepare('INSERT INTO notifications (vote,publication) VALUES (?,?)');
            $notify->execute(array($_SESSION['id'],$_POST['id']));
            exit('disliked');
        }
    }
}
?>