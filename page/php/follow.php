<?php
session_start();
if(isset($_POST['follow'])){
    require('../../public/php/pdo.php');
    $hasFollowed = $db->prepare('SELECT * FROM members WHERE page = ? AND profile = ?');
    $hasFollowed->execute(array(htmlspecialchars($_POST['id']), $_SESSION['id']));
    $ifFollow = $hasFollowed->rowCount();
    if($ifFollow == 0){
        $follow = $db->prepare('INSERT INTO members (page,profile) VALUES (?,?)');
        $follow->execute(array(htmlspecialchars($_POST['id']), $_SESSION['id']));
    }else{
            $unfollow = $db->prepare('DELETE FROM members WHERE page = ? AND profile = ?');
            $unfollow->execute(array(htmlspecialchars($_POST['id']), $_SESSION['id']));
    }
    exit('done');
}
?>