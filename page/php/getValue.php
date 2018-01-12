<?php
if(isset($_POST['progress'])){
    require('../../php/user.functions.php');
    $exit = '';
    $exit .= getProgress($_POST['id']);
    exit($exit);
}
?>