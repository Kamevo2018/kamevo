<?php
if(isset($_POST['progress'])){
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require($root.'/php/user.functions.php');
    $exit = '';
    $exit .= getProgress($_POST['id']);
    exit($exit);
}
?>