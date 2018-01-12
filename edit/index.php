<?php
session_start();
if(isset($_SESSION['id'])){
	require('../php/user.functions.php');
	require('../php/group.functions.php');
	require('../php/global.functions.php');
}else{
	header('Location: ../connection/');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Modifier mes informations</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Besoin de mofifier quelque chose sur votre profil ? C'est ici que ça se passe !">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
<?php require('../php/menu.php'); ?>
	<div class="container">
		<img src="../img/kamico.png" alt="kamico" class="kamico">
		<h3 class='title'>Modifier mes informations</h3>
		<div class="cedit">
			<p class="label">Que voulez-vous faire ?</p><br/><br/>
			<a href="p/name.php" class="edit-link"><div class="fullwidth"><i class="fa fa-user" aria-hidden="true"></i> - Modifier mon pseudo</div></a>
			<a href="p/biography.php" class="edit-link"><div class="fullwidth"><i class="fa fa-pencil" aria-hidden="true"></i> - Modifier ma biographie</div></a>
			<a href="p/profile.php" class="edit-link"><div class="fullwidth"><i class="fa fa-image" aria-hidden="true"></i> - Modifier mon image de profil</div></a>
			<a href="p/cover.php" class="edit-link"><div class="fullwidth"><i class="fa fa-image" aria-hidden="true"></i> - Modifier mon image de couverture</div></a>
			<br/>
			<p class="userinfo"><span class="fw900">Connecté en tant que :</span> <?= $_SESSION['pseudo'] ?></p>
		</div>
	</div>
<script src="js/ajax/search.js" type="text/javascript"></script>
</body>
</html>