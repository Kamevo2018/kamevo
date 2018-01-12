<?php
$hasSeen = $db->prepare('SELECT * FROM views WHERE publication = ? AND ip = ?');
$hasSeen->execute(array(htmlspecialchars($_GET['id']),get_client_ip()));
$ifHasSeen = $hasSeen->rowCount();
if($ifHasSeen == 0){
    $see = $db->prepare('INSERT INTO views (publication,author,ip) VALUES (?,?,?)');
    $see->execute(array(htmlspecialchars($_GET['id']),$publication['author'],get_client_ip()));
}
?>