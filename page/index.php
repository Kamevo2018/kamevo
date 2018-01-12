<?php
session_start();
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../php/global.functions.php');
require('../public/php/pdo.php');
$userExist = $db->prepare('SELECT * FROM groups WHERE id = ?');
$userExist->execute(array(htmlspecialchars(intval($_GET['group']))));
$exist = $userExist->rowCount();
if($exist == 0){ header('Location: ../group/'); }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo.com - <?= getGroupInfos($_GET['group'], 'name'); ?></title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - <?= getGroupInfos($_GET['group'], 'name'); ?> - <?= getGroupInfos($_GET['group'], 'description'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../css/flux.css">
	<link rel="stylesheet" href="../css/responsive.css">
	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>
<?php require('../php/menu.php'); ?>
<div class="group-widget">
	<h3 class="group-name"><?= getGroupInfos($_GET['group'], 'name'); ?></h3>
	<div class="group-infos">
		<p class="group-info">Membres <span class="orange fright"><?= countMembers($_GET['group']); ?></span></p>
		<p class="group-info">Publications <span class="orange fright"><?= countGroupPublications($_GET['group']); ?></span></p>
		<p class="group-info">Créateur <span class="orange fright"><?= getUserInfos(getGroupInfos($_GET['group'], 'author'), 'pseudo'); ?></span></p>
		<p class="group-info">Création <span class="orange fright">Le <?= date(" d M Y", strtotime(getGroupInfos($_GET['group'], "creation"))); ?></span></p>
		<a href="#" class="group-subscribe" onClick="follow(<?= intval($_GET['group']); ?>,<?= $_SESSION['id']; ?>)"><p class="group-info backorange"><b><?= followBtn(htmlspecialchars($_GET['group']),$_SESSION['id']) ?></b></p></a>
	</div>
</div>
<?php require('../php/notifications.php'); ?>
<div class="widget-fade"></div>
<div class="flux-container" id="<?= htmlspecialchars($_GET['group']); ?>">
	<div class="flux-hello">
		<h4><b><?= getGroupInfos($_GET['group'], 'name'); ?></b></h4>
		<p><?= getGroupInfos($_GET['group'], 'description'); ?></a></p>
	</div><br/>
</div>
<br/>
 <script src="../js/homepage/mobile.js"></script>
 <script src="../js/homepage/notifications.js"></script>
 <script src="../js/ajax/follow.js"></script>
 <script src="js/ajax/search.js"></script>
 <script src="js/ajax/vote.js"></script>
 <script src="js/ajax/flux.js"></script>
</body>
</html>