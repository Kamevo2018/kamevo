<?php
if(isset($_POST['like'])){
    require('../../public/php/pdo.php');
    $disliked = $db->prepare('SELECT * FROM likes WHERE (publication = ? AND liker = ?)');
    $disliked->execute(array($_POST['id'],$_POST['user']));
    $hasDisliked = $disliked->rowCount();
    if($hasDisliked > 0){
        $unDislike = $db->prepare('DELETE FROM likes WHERE publication = ? AND liker = ?');
        $unDislike->execute(array($_POST['id'],$_POST['user']));
        exit('unLiked');
    }else{
        $liked = $db->prepare('SELECT * FROM dislikes WHERE publication = ? AND disliker = ?');
        $liked->execute(array($_POST['id'],$_POST['user']));
        $hasLiked = $liked->rowCount();
        if($hasLiked > 0){
            $unLike = $db->prepare('DELETE FROM dislikes WHERE publication = ? AND disliker = ?');
            $unLike->execute(array($_POST['id'],$_POST['user']));
        }
        $dislike = $db->prepare('INSERT INTO likes (publication,liker) VALUES (?,?)');
        $dislike->execute(array($_POST['id'],$_POST['user']));
        exit('liked');
    }
}
?>