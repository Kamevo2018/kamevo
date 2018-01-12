<?php
session_start();
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../php/global.functions.php');
require('../public/php/pdo.php');
$userExist = $db->prepare('SELECT * FROM users WHERE id = ?');
$userExist->execute(array(htmlspecialchars(intval($_GET['user']))));
$exist = $userExist->rowCount();
if($exist == 0){ header('Location: ?user=1'); }
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - <?= getUserInfos($_GET['user'], 'pseudo'); ?></title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="<?= getUserInfos($_GET['user'], 'pseudo'); ?> - <?= getUserInfos($_GET['user'], 'biography'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">	
	<link rel="stylesheet" href="../css/style.max.css"> 
	<link rel="stylesheet" href="css/style.max.css">  
	 <link rel="stylesheet" href="../css/menu.css"> 
	<link rel="stylesheet" href="../css/flux.css"> 
	 <link rel="stylesheet" href="../css/responsive.css">    
	 <link rel="stylesheet" href="css/responsive.css">    
</head>
<body>
<?php require('../php/menu.php'); ?>
<style>.profile-header{background-image:url(../img/upload/<?= getUserInfos($_GET['user'], 'cover'); ?>); background-size: cover;}</style>
<div class="profile-header" id="<?= intval($_GET['id']); ?>">
	<img src="../img/upload/<?= getUserInfos($_GET['user'], 'avatar'); ?>" alt="avatar" class="profile-picture">
	<?php
		if(getUserInfos($_GET['user'], 'permission') == 'admin'){
			echo '<span class="profile-status">Administrateur</span>';
		}elseif(getUserInfos($_GET['user'], 'permission') == 'community'){
			echo '<span class="profile-status">Community Manager</span>';			
		}
		elseif(getUserInfos($_GET['user'], 'permission') == 'beta'){
			echo '<span class="profile-status">Bêta testeur</span>';			
		}elseif(getUserInfos($_GET['user'], 'permission') == 'certified'){
			echo '<span class="profile-status">Compte certifié</span>';			
		}
	?>
	<div class="profile-infos">
		<span class="profile-info"><b><?= getUserInfos($_GET['user'], 'pseudo'); ?></b></span>
		<span class="profile-info"><span class="bold"><?= getUserInfos($_GET['user'], 'points'); ?></span> points</span>
		<span class="profile-info"><span class="bold"><?= getSubs($_GET['user']); ?></span> abonnés</span>
		<span class="profile-info"><span class="bold"><?= countPublications($_GET['user']); ?></span> publications</span>
		<span class="profile-info">Depuis le <span class="bold"><?= date(" d M Y", strtotime(getUserInfos($_GET['user'], "creation"))); ?></span></span>
		<span class="profile-info"><?= subBtn($_GET['user'], $_SESSION['id']); ?></span>
	</div>
</div>
<div class="widget-fade"></div>
<?php require('../php/notifications.php'); ?>
<div class="flux-container">
	<div class="flux-hello mt-10">
		<h4><b>Bienvenue sur le profil de <?= getUserInfos($_GET['user'], 'pseudo'); ?></b></h4>
		<p><?= getUserInfos($_GET['user'], 'biography'); ?></p>
	</div><br/>
	<?php
	$getPublications = $db->prepare('SELECT * FROM publications WHERE author = ? ORDER BY id DESC');
		$getPublications->execute(array($_GET['user']));
		$hasPublications = $getPublications->rowCount();
		if($hasPublications > 0){
			while($publication = $getPublications->fetch()) {
				if($publication['image'] == 'none' AND $publication['video'] == 'none'){
						echo '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="https://kamevo.com/img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
								<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
								'.myPublication($publication['id'],$_SESSION['id']).'
							</div>
							<div class="flux-block-content">
								<p>'.$publication['content'].'</p>
							</div>
							<div class="flux-block-tools">
								<span class="like '.liked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-like" onClick="like($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
								</span>
								<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-dislike" onClick="dislike($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="comment">
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}elseif($publication['image'] != 'none'){
						echo '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="https://kamevo.com/img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
								<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
								'.myPublication($publication['id'],$_SESSION['id']).'
							</div>
							<div class="flux-block-content">
								<p>'.$publication['content'].'</p>
							</div>
							<div class="flux-block-image">
								<img src="https://kamevo.com/img/upload/'.$publication['image'].'" alt="flux-image" class="flux-block-img">
							</div>
							<div class="flux-block-tools">
								<span class="like '.liked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-like" onClick="like($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
								</span>
								<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-dislike" onClick="dislike($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="comment">
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}elseif($publication['video'] != 'none'){
						echo '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
								<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
								'.myPublication($publication['id'],$_SESSION['id']).'
							</div>
							<div class="flux-block-content">
								<p>'.$publication['content'].'</p>
							</div>
							<div class="flux-block-image">
								'.$publication['video'].'
							</div>
							<div class="flux-block-tools">
								<span class="like '.liked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-like" onClick="like($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
								</span>
								<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-dislike" onClick="dislike($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="comment">
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}
			}
			// End of publications
			echo '<div class="flux-hello mt10">
				<h4 align="center"><b>Fin des publications</b></h4>
			</div>';
		}else{
			echo '<div class="flux-hello mt10">
			<h4 align="center"><b>Aucune publication</b></h4>
		</div>';
		}
?>
</div>
<script>$(document).on('click','.subtn',function(){var user = <?= $_GET['user'] ?>;subscribe(user);});</script>
<script type="text/javascript" src="../js/homepage/mobile.js"></script>
<script type="text/javascript" src="../js/homepage/notifications.js"></script>
<script type="text/javascript" src="js/ajax/subscribe.js"></script>
<script type="text/javascript" src="js/ajax/vote.js"></script>
<script type="text/javascript" src="js/ajax/search.js"></script>
<script type="text/javascript" src="js/ajax/flux.js"></script>
</body>
</html>