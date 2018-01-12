<?php
    //Setting up the database
    $dsn = 'mysql:dbname=kamevo;host=localhost';
    $user = 'root';
    $password = '3VqF;wc=K.57w*7C3e]D';
    $db = new PDO($dsn, $user, $password);

    //Get group's infos
    function getGroupInfos($id,$info){
        global $db;
        $getGroupInfos = $db->prepare('SELECT * FROM groups WHERE id = ?');
            $getGroupInfos->execute(array($id));
        $groupInfo = $getGroupInfos->fetch();
        // Returning
        return $groupInfo[$info];
    }

    //Get group's publications count
    function countGroupPublications($id){
        global $db;
        $getCount = $db->prepare('SELECT * FROM publications WHERE target = ?');
            $getCount->execute(array($id));
        $countPublications = $getCount->rowCount();
        // Returning
        return $countPublications;
    }

    //Count group's members
    function countMembers($id){
        global $db;
        $countMembers = $db->prepare('SELECT * FROM members WHERE page = ?');
            $countMembers->execute(array($id));
        $members = $countMembers->rowCount();
        // Returning
        return $members;
    }

    // If publication in group
    function inPublication($id){
        global $db;
        $inPulication = $db->prepare('SELECT * FROM publications WHERE id = ?');
        $inPulication->execute(array($id));
        $publication = $inPulication->fetch();
        if(intval($publication['target']) != 0){
            return '<span class="flux-black"><a href="https://kamevo.com/page/?group='.$publication['target'].'" class="flux-black"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.utf8_encode(getGroupInfos($publication['target'], 'name')).'</a></span>';
        }else{
            return '';
        }
    }

    // Follow btn
    function followBtn($id,$user){
        global $db;
        $userFollow = $db->prepare('SELECT * FROM members WHERE page = ? AND profile = ?');
            $userFollow->execute(array(htmlspecialchars($id),htmlspecialchars($user)));
        $follow = $userFollow->rowCount();
        if($follow == 0){
            return 'Suivre ce groupe';
        }else{
            return 'Ne plus suivre ce groupe';
        }
    }
?>