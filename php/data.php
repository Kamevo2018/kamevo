<?php
session_start();
	if (isset($_POST['getData'])) {

	require('../public/php/pdo.php');
	require('../php/group.functions.php');

		$getWTP = $db->prepare('SELECT * FROM subs WHERE subscriber = ?');
		$getWTP->execute(array($_SESSION['id']));
		$WTP = $getWTP->fetchAll();
		array_push($WTP, array("profile" => $_SESSION['id']));
		array_push($WTP, array("profile" => 1));
		// Récupérer les groupes suivis
		$getMembers = $db->prepare('SELECT * FROM members WHERE profile = ?');
		$getMembers->execute(array($_SESSION['id']));
		$GTP = $getMembers->fetchAll();
		array_push($GTP, array("page" => -1));
		// Récupérer les publications partagées
		$getShared = $db->prepare('SELECT * FROM share WHERE (shared IN (' . implode(',', array_map('intval', array_column($WTP, 'profile'))) . '))');
		$getShared->execute();
		$STP = $getShared->fetchAll();
		array_push($STP, array("publication" => -1));
		//  AND (target IN (' . implode(',', array_map('intval', array_column($target, 'target'))) . '))
			$getPublications = $db->prepare('SELECT * FROM publications WHERE (author IN (' . implode(',', array_map('intval', array_column($WTP, 'profile'))) . ')) OR (target IN (' . implode(',', array_map('intval', array_column($GTP, 'page'))) . ')) OR (target IN (' . implode(',', array_map('intval', array_column($GTP, 'page'))) . ')) OR (id IN (' . implode(',', array_map('intval', array_column($STP, 'publication'))) . ')) ORDER BY id DESC LIMIT :start, :limit');
			$getPublications->bindValue(':start', intval($_POST['start']), PDO::PARAM_INT);
			$getPublications->bindValue(':limit', intval($_POST['limit']), PDO::PARAM_INT);
			$getPublications->execute();
			if ($getPublications->rowCount() > 0) {
				$response = "";
				require('../php/user.functions.php');
				while($publication = $getPublications->fetch()) {
					if($publication['image'] == 'none' AND $publication['video'] == 'none'){
						$response .= '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="profile/?user='.$publication['author'].'" class="orange"><img src="img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
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
									<a href="more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}elseif($publication['image'] != 'none' AND $publication['video'] == 'none'){
						$response .= '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="profile/?user='.$publication['author'].'" class="orange"><img src="img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
									<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
								'.myPublication($publication['id'],$_SESSION['id']).'
							</div>
							<div class="flux-block-content">
								<p>'.$publication['content'].'</p>
							</div>
							<div class="flux-block-image">
								<img src="img/upload/'.$publication['image'].'" alt="flux-image" class="flux-block-img">
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
									<a href="more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}elseif($publication['image'] == 'none' AND $publication['video'] != 'none'){
						$response .= '<div class="flux-block"  id="'.$publication['id'].'">
						'.byShared($publication['id'],$_SESSION['id']).'
							<div class="flux-block-header">
								<a href="profile/?user='.$publication['author'].'" class="orange"><img src="img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
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
			} else{
				$response = 'max';
				exit($response);
			}
	}
?>