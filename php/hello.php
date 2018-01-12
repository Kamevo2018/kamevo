<?php
    require('public/php/pdo.php');
    // If isset a public message
    // Else -> Echo Hello message
    // But first, let's welcome a new user
    $ifUnSubed = $db->prepare('SELECT * FROM subs WHERE subscriber = ?');
    $ifUnSubed->execute(array($_SESSION['id']));
    $isSubed = $ifUnSubed->rowCount();
    if($isSubed > 0){
        $getPublicMessage = $db->prepare('SELECT * FROM publicmessage ORDER BY id DESC');
        $getPublicMessage->execute();
        $publicMessage = $getPublicMessage->fetch();
        if(date('D') == 'Sun') { 
            echo '<style>.week-user-head{background-image: url("../img/upload/'.getUserInfos(weekUser(), 'cover').'");}</style>
                <a href="https://kamevo.com/profile/?user='.weekUser().'" class="nodeco"><div class="week-user">
                    <span class="week-user-banner"><i>Utilisateur de la semaine</i></span>
                    <div class="week-user-head">
                        <img src="img/upload/'.getUserInfos(weekUser(), 'avatar').'" alt="week-user-avatar" class="week-user-avatar">
                    </div>
                    <div class="week-user-infos">
                        <span class="week-user-info"><a href="https://kamevo.com/profile/?user='.weekUser().'" class="week-user-profile"><b><i class="fa fa-trophy" aria-hidden="true"></i> '.getUserInfos(weekUser(), 'pseudo').'</b></a> - '.getUserInfos(weekUser(), 'points').' points <span class="fz12"> <i>('.getCatName(getUserInfos(weekUser(), 'category')).')</i></span></span>
                    </div>
                </div></a>';
        }else{
            if(intval($publicMessage['duration']) > time()){
                echo '<div class="flux-hello">
                    <h4><b>'.$publicMessage['title'].'</b></h4>
                    <p>'.nl2br($publicMessage['content']).'</p>
                </div>';
            }else{
                echo '<div class="flux-hello">
                    <h4><b>Bonjour '.$_SESSION['firstname'].' !</b></h4>
                    <p>Nous espérons que votre expérience sur la plateforme est la plus positive possible ! Dans le cas contraire, <a href="feedback/" class="hello-link"><b>aidez-nous à nous amliorer !</b></a></p>
                </div>';
            }
        }
    }else{
        echo '<div class="flux-hello">
            <h4><b>Bienvenue '.$_SESSION['firstname'].' sur Kamevo !</b></h4>
                <p>Vous ne suivez personne pour le moment, remédiez à cela en recherchant des utilisateurs à l\'aide de la barre de recherche ci-dessus, ou cliquez <a href="https://kamevo.com/discover/" class="orange">ici</a> pour découvrir de nouveaux profils selon vos centres d\'intérêts</p><br/>
        </div>
        <img src="img/k-welcome.png" alt="Welcome on Kamevo" class="welcome-img">
        <div class="flux-hello mt10" align="center"><h4 class="welcome-title"><b>Vous ne suivez personne</b></h4></div>';
    }
?>