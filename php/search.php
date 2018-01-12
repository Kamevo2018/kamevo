<?php
session_start();
if(isset($_POST['value'])){
    require('../public/php/pdo.php');
    require('../php/user.functions.php');
    require('../php/group.functions.php');
    $findUser = $db->prepare('SELECT * FROM users WHERE pseudo LIKE :value');
    $findUser->execute(array(':value' => '%'.htmlspecialchars($_POST['value']).'%'));
    $response = '';
    while($user = $findUser->fetch()){
        $response .= '<a href="profile/?user='.$user['id'].'" class="i-res"><img src="img/upload/'.getUserInfos($user['id'], 'avatar').'" alt="i-res-image" class="i-res-image"><div class="input-result"><b>'.utf8_encode($user['pseudo']).' <span class="norange">('.checkSubS($user['id'],$_SESSION['id']).' )</span></b></div></a>';
    }
    $findGroup = $db->prepare('SELECT * FROM groups WHERE name LIKE :value');
    $findGroup->execute(array(':value' => '%'.htmlspecialchars($_POST['value']).'%'));
     while($group = $findGroup->fetch()){
        $response .= '<a href="page/?group='.$group['id'].'" class="i-res"><img src="img/upload/'.getGroupInfos($group['id'], 'avatar').'" alt="i-res-image" class="i-res-image"><div class="input-result"><b>'.utf8_encode($group['name']).' <span class="norange">( Groupe )</span></b></div></a>';
    }
    exit($response);
}
?>