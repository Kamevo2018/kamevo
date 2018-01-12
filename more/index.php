<?php
session_start();
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../php/global.functions.php');
$id = intval($_GET['id']);
if(isset($_GET['id']) AND is_int($id)){
	require('../public/php/pdo.php');
	$getPublication = $db->prepare('SELECT * FROM publications WHERE id = ?');
		$getPublication->execute(array(htmlspecialchars($id)));
	$publication = $getPublication->fetch();
	if($getPublication->rowCount() == 0){
		header('Location: ../');
	}
}else{
	header('Location: ../');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<title>Kamevo.com - Publication de <?= getUserInfos($publication['author'], 'pseudo'); ?> le <?= date(" d M Y", strtotime($publication['date'])); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="description" content="<?= $publication['content']; ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../css/flux.css">
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../css/responsive.css">
	<link rel="stylesheet" href="css/style.max.css">
</head>
<body>
<?php require('../php/menu.php'); ?>
<?php require('php/more.php'); ?>
<?php require('../php/notifications.php'); ?>
<div class="widget-fade"></div>
<?php require('php/add_view.php'); ?>
 <script type="text/javascript" src="../js/homepage/mobile.js"></script>
 <script type="text/javascript" src="../js/homepage/notifications.js"></script>
 <script type="text/javascript" src="js/ajax/vote.js"></script>
 <script type="text/javascript" src="js/ajax/search.js"></script>
 <script type="text/javascript" src="js/ajax/flux.js"></script>
</body>
</html>