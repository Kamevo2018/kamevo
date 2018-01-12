<?php
session_start();
if(isset($_SESSION['id'])){
require('public/php/pdo.php');
require('php/group.functions.php');
require('php/global.functions.php');
require('php/publish.php');
// require('php/cookie_script.php');
if(isset($_COOKIE['cookies'])){

}else{
	setcookie("cookies", "seen",time()+(365*24*60*60));
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo</title>
	<link rel="icon" type="image/x-icon" href="img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Référencement de vidéastes et de vidéos. Rejoignez la communauté de Kamevo.com et profitez du référencement du meilleur du monde de l'audio-visuel du web. C'est gratuit, facile et en ligne !">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/flux.css">
	<link rel="stylesheet" href="css/widgets.css">
	<link rel="stylesheet" href="css/post.css">
	<link rel="stylesheet" href="css/responsive.css">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111688107-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-111688107-1');
	</script>
<body>
<?php
if(isset($_COOKIE['cookies'])){}else{
	echo '<div class="cookies">
			<p>Afin de vous fournir une meilleure expérience, Kamevo.com utilise des cookies pour stocker des informations. Aucune de ces informations ne sont sauvegardées sur nos serveurs. Pour continuer votre utilisation de la plateforme, merci d\'accepter leur utilisation.</p><br/>
			<div class="cookie-btn"><a href="#" class="cookies_seen">J\'ai compris et j\'accepte !</a></div>
		</div>
		<div class="cookie_fade"></div>';
}
?>
<?php require('php/widget.php'); ?>
<?php require('php/menu.php'); ?>
<div class="widget-fade"></div>
<div class="links-widget">
	<h3 class="widget-title">Raccourcis</h3>
	 <p class="widget-line"><span class="orange"><a href="group/" class="orange">+ Créer un groupe</a></span></p>
	 <p class="widget-line"><a href="#" class="orange notifications"><i class="fa fa-bell" aria-hidden="true"></i> </span> <span class="nc-norange">Notifications</span> <span class="notifications-counter"><?= countNotifications($_SESSION['id']); ?></span></a></p>
	<?php
		if($_SESSION['permission'] == 'admin'){
			echo '<p class="widget-line"><span class="orange"><a href="admin/" class="black-link"><i class="fa fa-lock orange" aria-hidden="true"></i> </span>Administration</a></p>';
		}
	?>
	<p class="widget-line"><span class="orange"><a href="discover/" class="black-link"><i class="fa fa-search orange" aria-hidden="true"></i> </span>Parcourir</a></p>
	<?php
		$getGroups = $db->prepare('SELECT * FROM members WHERE profile = ? ORDER BY date DESC');
		$getGroups->execute(array($_SESSION['id']));
		$ifGroups = $getGroups->rowCount();
		if($ifGroups > 0){
			echo '<br/><h3 class="widget-title">Mes groupes</h3>';
			while($group = $getGroups->fetch()){
				echo '<p class="widget-line"><span class="orange"><a href="page/?group='.$group['page'].'" class="black-link"><i class="fa fa-users orange" aria-hidden="true"></i> </span>'.utf8_encode(getGroupInfos($group['page'], 'name')).'</a></p>';
			}
		}else{}
	?>
</div>
<?php
	require('php/notifications.php');
?>
<div class="flux-container">
	<?php
	if(isset($postError)){
		echo '<div class="postError">
			<p class="postError-error">'.$postError.'</p>
		</div>';
	}
	if(isset($postSuccess)){
		echo '<div class="postSuccess">
			<p class="postSuccess-error">'.$postSuccess.'</p>
		</div>';
	}
	require('php/hello.php'); 
?>
	<?php // echo '<div class="flux-block top-mb-n"><div class="flux-block-header"><img src="img/kamico.png" alt="flux-avatar" class="flux-block-avatar"><h4 class="flux-block-author">Publicité</h4><span class="flux-block-date">Kamevo.com</span><span class="flux-block-status">Sponsorisé</span></div><div class="flux-block-content"><p>Cette publication est sponsorisée par Kamevo</p></div><div class="flux-block-image"><img src="img/pub.png" alt="flux-image" class="flux-block-img"></div></div>'; ?>
</div>
<div class="publisher">
	<a href="#" class="publisher-btn"><i class="fa fa-edit" aria-hidden="true"></i></a>
</div>
<?php require('php/publisher.php'); ?>
 <script type="text/javascript" src="js/homepage/publisher.js"></script>
 <script type="text/javascript" src="js/homepage/menu.js"></script>
 <script type="text/javascript" src="js/homepage/mobile.js"></script>
 <script type="text/javascript" src="js/homepage/cookie.js"></script>
 <script type="text/javascript" src="js/homepage/flux.js"></script>
 <script type="text/javascript" src="js/homepage/notifications.js"></script>
 <script type="text/javascript" src="js/ajax/homepage_ajax.js"></script>
 <script type="text/javascript" src="js/ajax/vote.js"></script>
 <script src="js/ajax/search.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{ 
	if(isset($_COOKIE['first_visit'])){
		header('Location: connection/'); 
	}else{
		setcookie("first_visit", "done",time()+(365*24*60*60));
		header('Location: inscription/');
	}
} ?>
