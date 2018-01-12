<?php
$getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
$getPublications->execute(array($_SESSION['id']));
$countPublications = $getPublications->rowCount();
if($countPublications > 0){ 
$publications = $getPublications->fetchAll();
$getAllNotifications = $db->prepare('SELECT * FROM notifications WHERE (publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')) OR (profile = ?) ORDER BY id DESC LIMIT 0,50');
$getAllNotifications->execute(array($_SESSION['id']));
?><div class="notifications-center">
    <div class="nc-header">
        <span class="orange"><b><i class="fa fa-bell" aria-hidden="true"></i> </span> Mes notifications <span class="nc-frigth orange" id="nc-closer">&times;</span></b>
    </div>
    <div class="nc-notifications">
<?php
while($notification = $getAllNotifications->fetch()){
    if($notification['publication'] != 0){
        if($notification['vote'] != 0){
	    if($notification['seen'] == 0){
                 echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification">
                 <img src="https://kamevo.com/img/upload/'.getUserInfos($notification['vote'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                    <p><span class="orange">'.getUserInfos($notification["vote"], "pseudo").'</span> a réagi à votre publication</p>
               </div></a>';
	    }else{
                echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification nc-seen">
                 <img src="https://kamevo.com/img/upload/'.getUserInfos($notification['vote'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                    <p><span class="orange">'.getUserInfos($notification["vote"], "pseudo").'</span> a réagi à votre publication</p>
                </div></a>';

	    }
        }
        elseif($notification['share'] != 0){
	    if($notification['seen'] == 0){
            echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification">
             <img src="https://kamevo.com/img/upload/'.getUserInfos($notification['share'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                <p><span class="orange">'.getUserInfos($notification["share"], "pseudo").'</span> a partagé à votre publication</p>
            </div></a>';
	    }else{
            	echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification nc-seen">
             	<img src="https://kamevo.com/img/upload/'.getUserInfos($notification['share'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                	<p><span class="orange">'.getUserInfos($notification["share"], "pseudo").'</span> a partagé à votre publication</p>
            	</div></a>';
	    }
        }
        elseif($notification['comment'] != 0){
	    if($notification['seen'] == 0){
            echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification">
             <img src="https://kamevo.com/img/upload/'.getUserInfos($notification['comment'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                <p><span class="orange">'.getUserInfos($notification["comment"], "pseudo").'</span> a commenté à votre publication</p>
            </div></a>';
	    }else{
            	echo '<a href="https://kamevo.com/more/?id='.$notification['publication'].'" class="nc-nodeco"><div class="nc-notification nc-seen">
             	<img src="https://kamevo.com/img/upload/'.getUserInfos($notification['comment'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                	<p><span class="orange">'.getUserInfos($notification["comment"], "pseudo").'</span> a commenté à votre publication</p>
           	 </div></a>';
	    }
        }
    }
    elseif($notification['profile'] != 0){
	if($notification['seen'] == 0){
             echo '<a href="https://kamevo.com/profile/?user='.$notification['subscribe'].'" class="nc-nodeco"><div class="nc-notification">
             <img src="https://kamevo.com/img/upload/'.getUserInfos($notification['subscribe'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                <p><span class="orange">'.getUserInfos($notification["subscribe"], "pseudo").'</span> a commencé à vous suivre</p>
            </div></a>';
	    }else{
             	echo '<a href="https://kamevo.com/profile/?user='.$notification['subscribe'].'" class="nc-nodeco"><div class="nc-notification nc-seen">
             	<img src="https://kamevo.com/img/upload/'.getUserInfos($notification['subscribe'], "avatar").'" alt="notification-avatar" class="nc-avatar">
                	<p><span class="orange">'.getUserInfos($notification["subscribe"], "pseudo").'</span> a commencé à vous suivre</p>
            	</div></a>';
	    }
    }
}
?>
</div>
</div>
<?php 
}else{ ?>
<div class="notifications-center">
    <div class="nc-header">
        <span class="orange"><b><i class="fa fa-bell" aria-hidden="true"></i> </span> Mes notifications <span class="nc-frigth orange" id="nc-closer">&times;</span></b>
    </div>
    <div class="nc-notifications"><div class="nc-notification nc-seen">
        <img src="https://kamevo.com/img/kamico.png" alt="notification-avatar" class="nc-avatar">
        <p>Vous n'avez aucune notification</p>
    </div>
    </div>
</div>
<?php } ?>