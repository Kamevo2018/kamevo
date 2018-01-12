<?php
session_start();
if($_SESSION['permission'] == 'admin'){
	require('../../php/global.functions.php');
}else{
	header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Administration - Kamevo.com</title>
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../../css/style.max.css">
	<link rel="stylesheet" href="../../css/menu.css">
	<link rel="stylesheet" href="../../css/responsive.css">
</head>
<body>
<header>
	<nav id="top-menu">
		<ul id="top-menu-box">
			<a href="#top" class="top-menu-link"><img src="../../img/kamico.png" alt="Kamico" class="top-menu-icon"></a>
  			 <a href="#" class="m-log" id="icon"></a>
			<div class="mn-res">
				<a href="../../" class="top-menu-link"><li class="top-item"><i class="fa fa-home" aria-hidden="true"></i> <b>Accueil</b></li></a>
					<form action="" class="top-form">
						<span class="top-search-bar-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
						<input type="seach" placeholder="Rechercher" name="top-search-bar" class="top-search-bar">
					</form>
				<a href="../../public/php/disconnect.php" class="top-menu-link"><li class="top-item top-notifications"><i class="fa fa-sign-out" aria-hidden="true"></i> <b>Déconnexion</b></li></a>
			</div>
			<div class="mn-mob">
				<span class="mn-icon"><a href="public/php/disconnect.php" class="nodeco"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
			</div>
		</ul>
	</nav>
</header>
<div class="m-h-filter"></div>
<div class="mobile-header">
	<div class="m-header">
		<img src="img/avatar.png" alt="profile-avatar" class="m-header-avatar">
		<h3 class="m-header-profile">Utilisateur</h3>
	</div>
	<div class="m-infos">
		<p class="m-info">Abonnés <span class="orange fright">0</span></p>
		<p class="m-info">Abonnements <span class="orange fright">0</span></p>
		<p class="m-info">Publications <span class="orange fright">0</span></p>
		<p class="m-info">Points <span class="orange fright">0</span></p>
	</div>
	<div class="m-links">
		<p><a href="#" class="m-link"><i class="fa fa-refresh" aria-hidden="true"></i> Roulette</a></p>
		<p><a href="#" class="m-orange">+ Créer un groupe</a></p>
	</div>
</div>
	<div class="container">
		<h3 class='title'>Espace d'administration</h3>
		<div class="cedit">
			<p class="label"><i class="fa fa-bar-chart" aria-hidden="true"></i> Kamevo.com - statistiques</p><br/><br/>
			<span class="edit-link"><div class="fullwidth"><i class="fa fa-user" aria-hidden="true"></i> - <?= users(); ?> utilisateurs</div></span>
			<span class="edit-link"><div class="fullwidth"><i class="fa fa-pencil" aria-hidden="true"></i> - <?= publications(); ?> publications</div></span>
			<span class="edit-link"><div class="fullwidth"><i class="fa fa-users" aria-hidden="true"></i> - <?= groups(); ?> groupes</div></span>
			<span class="edit-link"><div class="fullwidth"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <i class="fa fa-thumbs-down" aria-hidden="true"></i> - <?= comments(); ?> commentaires</div></span>
			<span class="edit-link"><div class="fullwidth"><i class="fa fa-envelope" aria-hidden="true"></i> - <?= feedback(); ?> retours sur la plateforme</div></span>
		</div>
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>