<?php
session_start();
	if (isset($_POST['getData'])) {

	require('../../public/php/pdo.php');

		$getWTP = $db->prepare('SELECT * FROM subs WHERE subscriber = ?');
		$getWTP->execute(array($_SESSION['id']));
		$WTP = $getWTP->fetchAll();
		$getPublications = $db->prepare('SELECT * FROM publications WHERE author = :author ORDER BY id DESC LIMIT :start, :limit');
		$getPublications->bindValue(':author', intval($_POST['user']), PDO::PARAM_INT);
		$getPublications->bindValue(':start', intval($_POST['start']), PDO::PARAM_INT);
		$getPublications->bindValue(':limit', intval($_POST['limit']), PDO::PARAM_INT);
        $getPublications->execute();
		if ($getPublications->rowCount() > 0) {
			$response = "";
			require('../../php/user.functions.php');
			while($publication = $getPublications->fetch()) {
				if($publication['image'] == 'none'){
					$response .= '<div class="flux-block">
						<div class="flux-block-header">
							<img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
								<h4 class="flux-block-author">'.getUserInfos($publication['author'],'pseudo').'</h4>
								<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
							<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
						</div>
						<div class="flux-block-content">
							<p>'.$publication['content'].'</p>
						</div>
						<div class="flux-block-tools">
							<span class="like '.liked($publication['id'], $_SESSION['id']).'">
								<a href="#like" class="b-like" onClick="like($(this).attr(\'id\'))" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
							</span>
							<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'">
								<a href="#like" class="b-dislike" onClick="dislike($(this).attr(\'id\'))" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
							</span>
							<span class="comment">
								<a href="../more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
							</span>
							<span class="progress">
								<progress id="avancement" class="avancementid165 progress-one" value="50" max="100"></progress>
							</span>
						</div>
					</div>';
				}elseif($publication['image'] != 'none' AND $publication['video'] == 'none'){
					$response .= '<div class="flux-block">
						<div class="flux-block-header">
							<img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
								<h4 class="flux-block-author">'.getUserInfos($publication['author'],'pseudo').'</h4>
								<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
							<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
						</div>
						<div class="flux-block-content">
							<p>'.$publication['content'].'</p>
						</div>
						<div class="flux-block-image">
							<img src="../img/upload/'.$publication['image'].'" alt="flux-image" class="flux-block-img">
						</div>
						<div class="flux-block-tools">
							<div class="likes-tools">
							<span class="like '.liked($publication['id'], $_SESSION['id']).'">
								<a href="#like" class="b-like" onClick="like($(this).attr(\'id\'))" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
							</span>
							<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'>
								<a href="#like" class="b-dislike" onClick="dislike($(this).attr(\'id\'))" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
							</span>
							</div>
							<span class="comment">
								<a href="../more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
							</span>
							<span class="progress">
								<progress id="avancement" class="avancementid165 progress-one" value="'.getProgress($publication['id']).'" max="100"></progress>
							</span>
						</div>
					</div>';
				}elseif($publication['image'] == 'none' AND $publication['video'] != 'none'){
						$response .= '<div class="flux-block">
							<div class="flux-block-header">
								<a href="profile/?user='.$publication['author'].'" class="orange"><img src="img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
								<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
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
								<span class="comment">
									<a href="more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}
			}

			exit($response);
		} else
			$response = '<br/><div class="flux-hello">
				<h4 align="center"><b>Fin des publications</b></h4>
			</div>';
			exit($response);
	}
?>