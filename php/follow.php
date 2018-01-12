<?php
if(isset($_POST['follow'])){
    require('../public/php/pdo.php');
    $hasFollowed = $db->prepare('SELECT * FROM members WHERE page = ? AND profile = ?');
    $hasFollowed->execute(array(htmlspecialchars($_POST['id']), htmlspecialchars($_POST['user'])));
    $ifFollow = $hasFollowed->rowCount();
    if($ifFollow == 0){
        $follow = $db->prepare('INSERT INTO members (page,profile) VALUES (?,?)');
        $follow->execute(array($_POST['id']), htmlspecialchars($_POST['user'])));
    }else{
            $unfollow = $db->prepare('DELETE FROM members WHERE page = ? AND profile = ?');
            $unfollow->execute(array(htmlspecialchars($_POST['id'])), htmlspecialchars($_POST['user'])));
    }
    exit('Done');
}
?>