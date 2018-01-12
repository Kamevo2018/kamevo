<header>
	<nav id="top-menu">
		<ul id="top-menu-box">
			<a href="https://kamevo.com" class="top-menu-link"><img src="https://kamevo.com/img/kamico.png" alt="Kamico" class="top-menu-icon"></a>
  			 <a href="#" class="m-log" id="icon"></a>
			<div class="mn-res">
				<a href="https://kamevo.com" class="top-menu-link"><li class="top-item"><i class="fa fa-home" aria-hidden="true"></i> Accueil</li></a>
					<form action="" class="top-form">
						<span class="top-search-bar-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
						<input type="seach" placeholder="Rechercher un utilisateur ou un groupe" name="top-search-bar" class="top-search-bar">
					</form>
				<a href="https://kamevo.com/public/php/disconnect.php" class="top-menu-link"><li class="top-item top-notifications"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</li></a>
			</div>
			<div class="mn-mob">
				<span class="mn-icon"><a href="https://kamevo.com/public/php/disconnect.php" class="nodeco"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
			</div>
		</ul>
	</nav>
	<div class="input-results">
		
	</div>
</header>
<div class="m-h-filter"></div>
<div class="mobile-header">
	<a href="https://kamevo.com/profile/?user=<?= $_SESSION['id']; ?>"><div class="m-header">
		<img src="https://kamevo.com/img/upload/<?= getUserInfos($_SESSION['id'], 'avatar'); ?>" alt="profile-avatar" class="m-header-avatar">
		<h3 class="m-header-profile"><?= $_SESSION['pseudo']; ?></h3>
	</div></a>
	<div class="m-infos">
		<p class="m-info">Abonnés <span class="orange fright"><?= getSubs($_SESSION['id']); ?></span></p>
		<p class="m-info">Abonnements <span class="orange fright"><?= getSubsTo($_SESSION['id']); ?></span></p>
		<p class="m-info">Publications <span class="orange fright"><?= countPublications($_SESSION['id']); ?></span></p>
		<p class="m-info">Points <span class="orange fright"><?= getUserInfos($_SESSION['id'], 'points'); ?></span></p>
	</div>
	<div class="m-links">
		<p><a href="#" class="m-link notifications"><i class="fa fa-bell" aria-hidden="true"></i> Notifications <span class="notifications-counter"><?= countNotifications($_SESSION['id']); ?></span></a></p>
		<p><a href="https://kamevo.com/discover" class="m-link"><i class="fa fa-search" aria-hidden="true"></i> Parcourir</a></p>
		<p><a href="https://kamevo.com/group/" class="m-orange">+ Créer un groupe</a></p>
		<?php
			$getGroups = $db->prepare('SELECT * FROM members WHERE profile = ? ORDER BY date DESC');
			$getGroups->execute(array($_SESSION['id']));
			while($group = $getGroups->fetch()){
				echo '<p><a href="page/?group='.$group['page'].'" class="m-link"><i class="fa fa-users orange" aria-hidden="true"></i> '.utf8_decode(getGroupInfos($group['page'], 'name')).'</a></p>';
			}
		?>
	</div>
</div>