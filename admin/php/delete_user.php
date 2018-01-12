<?php
session_start();
if($_SESSION['permission'] == 'admin'){
    require('../../public/php/pdo.php');
    if(isset($_POST['submit'])){
        if(!empty($_POST['user'])){
        if(!empty($_POST['reason'])){
            $userExist = $db->prepare('SELECT * FROM users WHERE id = ?');
            $userExist->execute(array(htmlspecialchars($_POST['user'])));
			$user = $userExist->fetch();
            $exist = $userExist->rowCount();
            if($exist > 0){
                $deleteUser = $db->prepare('DELETE FROM users WHERE id = ?');
                $deleteUser->execute(array(htmlspecialchars($_POST['user'])));
                $success = 'Le compte de l\'utilisateur '.htmlspecialchars($_POST['user']).' a été supprimé';
                $header = "MIME-Version: 1.0\r\n";
                $header.= 'From:"Kamevo.com"<noreply@kamevo.com>'."\n";
                $header.= 'Content-Type:text/html; charset="utf-8"'."\n";
                $header.= 'Content-Transfer-Encoding: 8bit';
                mail($user['email'], 'Votre compte a été supprimé', 'Bonjour '.$user['firstname'].',<br/><br/> Votre compte utilisateur sur la plateforme Kamevo a été supprimé pour la raison suivante : <b>'.htmlspecialchars($_POST['reason']).'</b>.<br/> Si vous pensez qu\'il s\'agit d\'une erreur, contactez un membre de l\'équipe technique à l\'adresse suivante : support@kamevo.com.<br/><br/>À votre service,<br/>L\'équipe Kamevo.com', $header);
            }else{
                $error = 'L\'utilisateur n\'existe pas';
            }
        }else{
            $error = 'Veulliez donner la raison de la suppression';
        }
        }else{
            $error = 'Vous n\'avez pas saisi d\'identifiant';
        }
    }
}else{
	header('Location: ../');
}
?>
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
			<a href="#" class="top-menu-link"><img src="../../img/kamico.png" alt="Kamico" class="top-menu-icon"></a>
  			 <a href="#" class="m-log" id="icon"></a>
			<div class="mn-res">
				<a href="../../" class="top-menu-link"><li class="top-item"><i class="fa fa-home" aria-hidden="true"></i> <b>Accueil</b></li></a>
					<form action="" class="top-form">
						<span class="top-search-bar-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
						<input type="seach" placeholder="Rechercher" name="top-search-bar" class="top-search-bar">
					</form>
				<a href="../../public/php/disconnect.php" class="top-menu-link"><li class="top-item top-notifications"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</li></a>
			</div>
			<div class="mn-mob">
				<span class="mn-icon"><a href="#" class="nodeco"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
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
        	<?php
				if(isset($success)){
					echo '<div class="success">
						<p class="success-message">'.$success.'</p>
					</div>';
				}
				if(isset($error)){
					echo '<div class="error">
						<p class="error-message">'.$error.'</p>
					</div>';
				}
			?>
		 <div class="cedit">
			<p class="label">Supprimer un utilisateur</p><br/><br/>
			<form action="" method="post">
				<label for="user"><i class="fa fa-user" aria-hidden="true"></i> Id du compte</label>
				<input type="text" class="input" id="user" name="user">
				<label for="reason"><i class="fa fa-pencil" aria-hidden="true"></i> Raison de la suppression</label>
				<textarea type="text" class="input" id="reason" name="reason" rows="5"></textarea>
				<input type="submit" class="submit" name="submit" value="Supprimer le compte de l'utilisateur">
			</form>
		</div> 
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>