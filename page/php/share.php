<?php
session_start();
if(isset($_POST['share'])){
    require('../../public/php/pdo.php');
    $shared = $db->prepare('SELECT * FROM share WHERE (publication = ? AND shared = ?)');
    $shared->execute(array($_POST['id'],$_SESSION['id']));
    $hasShared = $shared->rowCount();
    if($hasShared > 0){
        $unShare = $db->prepare('DELETE FROM share WHERE publication = ? AND shared = ?');
        $unShare->execute(array($_POST['id'],$_SESSION['id']));
        exit('unShared');
    }else{
        $share = $db->prepare('INSERT INTO share (publication,shared) VALUES (?,?)');
        $share->execute(array($_POST['id'],$_SESSION['id']));
        exit('shared');
    }
}
?>