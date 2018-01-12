<?php
session_start();
require('../../php/user.functions.php');
require('../../php/group.functions.php');
require('../../public/php/pdo.php');
if(isset($_SESSION['id'])){
    $getBestProfiles = $db->prepare('SELECT * FROM users WHERE category = ? ORDER BY points DESC LIMIT 0,15');
    $getBestProfiles->execute(array('default'));
}else{
    header('Location: ../../connection/');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kamevo - Tout et n'importe quoi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="../../public/fonts.css">
	<link rel="icon" type="image/x-icon" href="../img/kamico.ico" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.max.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <link rel="stylesheet" href="../../css/post.css">
    <link rel="stylesheet" href="../../css/responsive.css">
    <link rel="stylesheet" href="css/style.max.css">
</head>
<body>
<?php require('../../php/menu.php'); ?>
<div class="container">
    <img src="../../img/kamico.png" alt="kamico" class="kamico">
    <h1 class="title">Kamevo - Tout et n'importe quoi</h1>
    <div class="cedit">
    <p class="label">Voici les 15 profils les mieux référencés par Kamevo :</p><br/><br/>
        <?php
        while($profile = $getBestProfiles->fetch()){
            echo '<a href="https://kamevo.com/profile/?user='.$profile['id'].'" class="c-link">
                <div class="c-profile">
                    <img src="../../img/upload/'.getUserInfos($profile['id'], "avatar").'" alt="profile-avatar" class="c-profile-avatar">
                    <p class="c-profile-pseudo">'.$profile['pseudo'].'<span class="dark"> - '.$profile['points'].' points</span></p>
                    <!-- 145  -->
                    <p class="c-profile-biography">'.substr($profile['biography'],0,145).'...</p>
                </div>
            </a>';
        }
        ?>
    </div>
</div>
<script type="text/javascript" src="../../js/homepage/mobile.js"></script>
</body>
</html>