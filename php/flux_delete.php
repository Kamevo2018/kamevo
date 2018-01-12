<?php
session_start();
if(isset($_POST['delete'])){
    require('../public/php/pdo.php');
    require('user.functions.php');
    if(getPublicationInfos($_POST['value'], "author") === $_SESSION['id']){
        $deletePublication = $db->prepare('DELETE FROM publications WHERE id = ?');
        $deletePublication->execute(array($_POST['value']));
        exit("Publication deleted");
    }else{
        exit("");
    }
}
?>