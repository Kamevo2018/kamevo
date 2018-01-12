<?php
session_start();
	if (isset($_POST['getData'])) {
	require('../../public/php/pdo.php');
		$getPublications = $db->prepare('SELECT * FROM publications WHERE target = :group ORDER BY id DESC LIMIT :start, :limit');
		$getPublications->bindValue(':group', intval($_POST['group']), PDO::PARAM_INT);
		$getPublications->bindValue(':start', intval($_POST['start']), PDO::PARAM_INT);
		$getPublications->bindValue(':limit', intval($_POST['limit']), PDO::PARAM_INT);
        $getPublications->execute();
		if ($getPublications->rowCount() > 0) {
			$response = "";
			require('../../php/user.functions.php');
			while($publication = $getPublications->fetch()) {
				if($publication['image'] == 'none' AND $publication['video'] == 'none'){
					$response .= '<div class="flux-block">
						'.byShared($publication['id'],$_SESSION['id']).'
						<div class="flux-block-header">
							<img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
								<h4 class="flux-block-author">'.getUserInfos($publication['author'],'pseudo').'</h4>
								<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
							<span class="flux-block-status">Abonné</span>
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
								<span class="comment">
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
					</div>';
				}elseif($publication['image'] != 'none'){
					$response .= '<div class="flux-block">
						'.byShared($publication['id'],$_SESSION['id']).'
						<div class="flux-block-header">
							<img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
								<h4 class="flux-block-author">'.getUserInfos($publication['author'],'pseudo').'</h4>
								<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
							<span class="flux-block-status">Abonné</span>
						</div>
						<div class="flux-block-content">
							<p>'.$publication['content'].'</p>
						</div>
						<div class="flux-block-image">
							<img src="../img/upload/'.$publication['image'].'" alt="flux-image" class="flux-block-img">
						</div>
							<div class="flux-block-tools">
								<span class="like '.liked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-like" onClick="like($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
								</span>
								<span class="dislike '.disliked($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-dislike" onClick="dislike($(this).attr(\'id\'),'.$_SESSION['id'].')" id="'.$publication['id'].'"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
								</span>
								<span class="comment">
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
					</div>';
				}elseif($publication['video'] != 'none'){
					$response .= '<div class="flux-block">
						'.byShared($publication['id'],$_SESSION['id']).'
						<div class="flux-block-header">
							<img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
								<h4 class="flux-block-author">'.getUserInfos($publication['author'],'pseudo').'</h4>
								<span class="flux-block-date">'.time_elapsed_string($publication['date']).'</span>
							<span class="flux-block-status">Abonné</span>
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
									<a href="https://kamevo.com/more/?id='.$publication['id'].'" class="tools-comment"><b>En savoir plus <i class="fa fa-caret-right" aria-hidden="true"></i></b></a>
								</span>
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
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