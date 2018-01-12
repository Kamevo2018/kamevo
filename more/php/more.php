<?php
session_start();
if(isset($_POST['submit']) AND isset($_SESSION['id'])){
	if(!empty($_POST['comment']) AND !empty(trim($_POST['comment']))){
		if(strlen($_POST['comment']) <= 250){
			$insertComment = $db->prepare('INSERT INTO comments (publication,author,content) VALUES (?,?,?)');
				$insertComment->execute(array($publication['id'],$_SESSION['id'], htmlspecialchars($_POST['comment'])));
			$insertComment->closeCursor();
            		$notify = $db->prepare('INSERT INTO notifications (comment,publication) VALUES (?,?)');
            		$notify->execute(array($_SESSION['id'],htmlspecialchars($_GET['id'])));
			$postSuccess = 'Votre commentaire a été posté';
		}else{
			$postError = 'Les commentaires ne peuvent pas dépasser 250 caractères';
		}
	}else{
		$postError = 'Un commentaire doit contenir du contenu';
	}
}
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
	if($publication['image'] == 'none' AND $publication['video'] == 'none'){
					echo '<div class="flux-block" id="'.$publication['id'].'">
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
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
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
				}elseif($publication['image'] != 'none'){
					echo '<div class="flux-block" id="'.$publication['id'].'">
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
								<span class="flux-block-status">'.checkSub($publication['author'], $_SESSION['id']).'</span>
								'.myPublication($publication['id'],$_SESSION['id']).'
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
								<span class="share '.shared($publication['id'], $_SESSION['id']).'">
									<a href="#" class="b-share" onClick="share('.$publication['id'].')"><i class="fa fa-retweet" aria-hidden="true"></i></a>
								</span>
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
				}elseif($publication['video'] != 'none'){
						echo '<div class="flux-block" id="'.$publication['id'].'">
							<div class="flux-block-header">
								<a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange"><img src="../img/upload/'.getUserInfos($publication['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar"></a>
									<h4 class="flux-block-author"><a href="https://kamevo.com/profile/?user='.$publication['author'].'" class="orange">'.getUserInfos($publication['author'],'pseudo').' '.inPublication($publication['id']).'</a></h4>
									<span class="flux-block-date">Le'.date(" d M Y", strtotime($publication['date'])).'</span>
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
								<span class="progress">
									<progress id="progress'.$publication['id'].'" value="'.getProgress($publication['id']).'" max="100" class="progress"></progress>
								</span>
							</div>
						</div>';
					}else{
						echo 'lo';
					}
		?>
		<div class="flux-block-comments">
			<?php
				$getComments = $db->prepare('SELECT * FROM comments WHERE publication = ? ORDER BY id DESC');
					$getComments->execute(array($publication['id']));
				$commentsCount = $getComments->rowCount();
			?>
			<div class="flux-block-comments-header">
				<p><b>Tous les commentaires <?= '('.$commentsCount.')'; ?> :</b></p>
			</div>
			<?php if(isset($_SESSION['id'])){ ?>
			<div class="flux-block-comment-publisher">
				<form action="" method="post">
					<label for="comment">Commenter cette publication ( 250 caractères max. ) :</label>
					<textarea name="comment" id="comment" class="input"></textarea>
					<input type="submit" name="submit" value="Publier mon commentaire" class="submit">
				</form>
			</div>
			<?php } ?>
			<?php
				while($comment = $getComments->fetch()){
					echo '<div class="flux-block-comment">
					<div class="flux-block-header nopadding">
						<img src="../img/upload/'.getUserInfos($comment['author'], "avatar").'" alt="flux-avatar" class="flux-block-avatar">
							<h4 class="flux-block-author">'.getUserInfos($comment['author'], 'pseudo').'</h4>
							<span class="flux-block-date comment-date">'.time_elapsed_string($comment['date']).'</span>
						<span class="flux-block-status">'.CheckSub($_SESSION['id'], $comment['author']).'</span>
					</div>
					<p class="comment-content">'.$comment['content'].'</p>
				</div>';
				}
			?>
		</div>
	</div>
	<br/>
</div>