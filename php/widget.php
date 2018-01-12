<?php require('user.functions.php'); ?>
<style>
.profile-widget-images{
	width: 100%;
	height: 80px;
	background-image: url("img/upload/<?= getUserInfos($_SESSION['id'], "cover") ?>");
	background-size: cover;
	background-position: center;
}
</style>
<div class="profile-widget">
	<a href="profile/?user=<?= $_SESSION['id'] ?>"><div class="profile-widget-images">
		<img src="img/upload/<?= getUserInfos($_SESSION['id'], "avatar") ?>" alt="Profile-picture" class="profile-picture">
	</div></a>
	<div class="profile-widget-infos">
		<p class="profile-widget-line"><span class="orange"><b><?= $_SESSION['pseudo']; ?></b></span></p><br/>
		 <p class="profile-widget-line"><span class="orange"><?= getSubs($_SESSION['id']); ?></span> abonné(s)</p>
		  <p class="profile-widget-line"><span class="orange"><?= getSubsTo($_SESSION['id']); ?></span> abonnement(s)</p>
		 <p class="profile-widget-line"><span class="orange"><?= countPublications($_SESSION['id']); ?></span> publications</p>
		<p class="profile-widget-line"><span class="orange"><?= getUserInfos($_SESSION['id'], 'points'); ?></span> points</p>
	</div>
</div>