<?php
if(isset($_POST['dislike'])){
    require('../../public/php/pdo.php');
    $disliked = $db->prepare('SELECT * FROM dislikes WHERE (publication = ? AND disliker = ?)');
    $disliked->execute(array($_POST['id'],$_POST['user']));
    $hasDisliked = $disliked->rowCount();
    if($hasDisliked > 0){
        $unDislike = $db->prepare('DELETE FROM dislikes WHERE publication = ? AND disliker = ?');
        $unDislike->execute(array($_POST['id'],$_POST['user']));
        exit('unDisliked');
    }else{
        $liked = $db->prepare('SELECT * FROM likes WHERE publication = ? AND liker = ?');
        $liked->execute(array($_POST['id'],$_POST['user']));
        $hasLiked = $liked->rowCount();
        if($hasLiked > 0){
            $unLike = $db->prepare('DELETE FROM likes WHERE publication = ? AND liker = ?');
            $unLike->execute(array($_POST['id'],$_POST['user']));
        }
        $dislike = $db->prepare('INSERT INTO dislikes (publication,disliker) VALUES (?,?)');
        $dislike->execute(array($_POST['id'],$_POST['user']));
        exit('disliked');
    }
}
?>