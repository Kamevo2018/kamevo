<?php
    //Setting up the database
    $dsn = 'mysql:dbname=kamevo;host=localhost';
    $user = 'root';
    $password = '';
    $db = new PDO($dsn, $user, $password);
        
    //Get user's subscribers
    function getSubs($id){
        global $db;
        $getSubs = $db->prepare('SELECT * FROM subs WHERE profile = ?');
            $getSubs->execute(array($id));
        $subs = $getSubs->rowCount();
        // Returning
        return $subs;
    }

    //Get user's subscribtion
    function getSubsTo($id){
        global $db;
        $getSubs = $db->prepare('SELECT * FROM subs WHERE subscriber = ?');
            $getSubs->execute(array($id));
        $subs = $getSubs->rowCount();
        // Returning
        return $subs;
    }

    //Get user's infos
    function getUserInfos($id,$info){
        global $db;
        $getUserInfos = $db->prepare('SELECT * FROM users WHERE id = ?');
            $getUserInfos->execute(array($id));
        $userInfo = $getUserInfos->fetch();
        // Returning
        return $userInfo[$info];
    }

    //Get user's publications count
    function countPublications($id){
        global $db;
        $getCount = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getCount->execute(array($id));
        $countPublications = $getCount->rowCount();
        // Returning
        return $countPublications;
    }

    //Get user's publications
    function getPublications($id){
        global $db;
            $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
        $getPublications->execute(array($id));
        return $getPublications;
    }

    //If user's sub for search bar
    function checkSubS($id, $profile){
        global $db;
            $checkSub = $db->prepare('SELECT * FROM subs WHERE profile = ? AND subscriber = ?');
        $checkSub->execute(array($id,$profile));
        if($checkSub->rowCount() > 0){
            return 'Abonné';
        }elseif($profile == $id){
            return 'Vous même';            
        }else{
            return 'Vous ne suivez pas ce profil';
        }
    }

    //If user's sub
    function checkSub($id, $profile){
        global $db;
            $checkSub = $db->prepare('SELECT * FROM subs WHERE profile = ? AND subscriber = ?');
        $checkSub->execute(array($id,$profile));
        if($checkSub->rowCount() > 0){
            return 'Abonné';
        }elseif($profile == $id){
            return 'Vous avez publié ceci';            
        }else{
            return 'Vous ne suivez pas ce profil';
        }
    }

    //If user liked
    function liked($publication, $id){
        global $db;
        $liked = $db->prepare('SELECT * FROM likes WHERE (publication = ?) AND (liker = ?)');
            $liked->execute(array($publication, $id));
        $hadLiked = $liked->rowCount();
        if($hadLiked == 0){
            return 'like';
        }else{
            return 'liked';
        }
    }

    //If user disliked
    function disliked($publication, $id){
        global $db;
        $disliked = $db->prepare('SELECT * FROM dislikes WHERE (publication = ?) AND (disliker = ?)');
            $disliked->execute(array($publication, $id));
        $hadDisliked = $disliked->rowCount();
        if($hadDisliked > 0){
            return 'disliked';
        }else{
            return 'dislike';
        }
    }
    
    //If user shared
    function shared($publication, $id){
        global $db;
        $shared = $db->prepare('SELECT * FROM share WHERE (publication = ?) AND (shared = ?)');
            $shared->execute(array($publication, $id));
        $hasShared = $shared->rowCount();
        if($hasShared > 0){
            return 'shared';
        }else{
            return 'share';
        }
    }

    //Like/dislike ratio
    function getProgress($publication){
        global $db;
            $getLikes = $db->prepare('SELECT * FROM likes WHERE publication = ?');
                $getLikes->execute(array($publication));
                    $getDislikes = $db->prepare('SELECT * FROM dislikes WHERE publication = ?');
                        $getDislikes->execute(array($publication));
                            $likes = $getLikes->rowCount();
                                $dislikes = $getDislikes->rowCount();
                            if($likes == 0 AND $dislikes > 0){$ratio = 0;}
                        elseif($dislikes == 0 AND $likes > 0){$ratio = 100;}
                     elseif($likes > 0 AND $dislikes > 0){
                $total = $likes + $dislikes;
            $ratio = ($likes/$total)*100;
            }else{
                $ratio = 50;
            }
        return $ratio;
    }

    //Sub btn's function
    function subBtn($profile, $id){
        global $db;
            $checkSub = $db->prepare('SELECT * FROM subs WHERE profile = ? AND subscriber = ?');
        $checkSub->execute(array($profile,$id));
        if($checkSub->rowCount() > 0){
            return '<span class="bold subtn">Abonné</span>';
        }elseif($profile == $id){
            return '<span class="bold"><a href="../edit/?user='.$id.'" class="bold"><i class="fa fa-pencil" aria-hidden="true"></i> Editer mon profil</a></span>';
        }else{
            return '<span class="red subtn">S\'abonner</span>';
        }
    }

    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    // If publication was shared
    function byShared($id,$user){
        global $db;
        // Get all subs
        $getWTP = $db->prepare('SELECT * FROM subs WHERE subscriber = ?');
        $getWTP->execute(array($user));
	$goFt= $getWTP->rowCount();
	if($goFt == 0){
	return;	
	}else{
        	$WTP = $getWTP->fetchAll();
        	// Get all shared publications
        	$getShared = $db->prepare('SELECT * FROM share WHERE (shared IN (' . implode(',', array_map('intval', array_column($WTP, 'profile'))) . ')) AND (publication = ?)');
        	$getShared->execute(array($id));
        	$wasShared = $getShared->rowCount();
        	if($wasShared > 0){
            	  $sharedBy = $getShared->fetch();
            	  $return = '<div class="flux-shared">
                            <span>Publication partagée par <a href="https://kamevo.com/profile/?user='.$sharedBy['shared'].'" class="flux-shared-profile">'.getUserInfos($sharedBy['shared'], 'pseudo').'</a></span>
                        </div>';
            	  return $return;
        	}else{
            		return;
        	}
	}
    }

    // Get user's notifications count
    function countNotifications($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($_SESSION['id']));
                $countPublications = $getPublications->rowCount();
                if($countPublications > 0){
                    $publications = $getPublications->fetchAll();
                   $getAllNotifications = $db->prepare('SELECT * FROM notifications WHERE (publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')) AND (seen = 0) OR (profile = ?) AND (seen = 0) ORDER BY id DESC');
               $getAllNotifications->execute(array($_SESSION['id']));
               $countNotifications = $getAllNotifications->rowCount();
               // Returning
               return $countNotifications;
            }else{
                return 0;
            }
    }

    // if publication belows to session
    function myPublication($id,$user){
        global $db;
        $getPublication = $db->prepare('SELECT * FROM publications WHERE id = ?');
        $getPublication->execute(array($id));
        $publication= $getPublication->fetch();
        if($publication['author'] === $user){
            return '<span class="flux-block-delete"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
            <div class="flux-block-delete-more delete-block-undisplayed">
                <a href="#" class="flux-block-delete-link">Supprimer</a>
            </div>';
        }else{
            return;
        }
    }

    //Get publication's infos
    function getPublicationInfos($id,$info){
        global $db;
        $getPublicationInfos = $db->prepare('SELECT * FROM publications WHERE id = ?');
            $getPublicationInfos->execute(array($id));
        $publicationInfo = $getPublicationInfos->fetch();
        // Returning
        return $publicationInfo[$info];
    }

        // elapsed time
        function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);
        
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        
            $string = array(
                'y' => 'an',
                'm' => 'mois',
                'w' => 'semaine',
                'd' => 'jour',
                'h' => 'heure',
                'i' => 'minute',
                's' => 'seconde',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }
        
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? 'Il y a ' . implode(', ', $string) : 'À l\'instant';
        }
?>
