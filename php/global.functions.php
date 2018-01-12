<?php
// Global functions
    //Setting up the database
    $dsn = 'mysql:dbname=kamevo;host=localhost';
    $user = 'root';
    $password = '3VqF;wc=K.57w*7C3e]D';
    $db = new PDO($dsn, $user, $password);

    // Users function
    function users(){
        global $db;
        $coutUsers = $db->prepare('SELECT * FROM users');
            $coutUsers->execute();
        $users = $coutUsers->rowCount();
        // Returning
        return $users;
    }

    // Publications function
    function publications(){
        global $db;
        $coutpublications = $db->prepare('SELECT * FROM publications');
            $coutpublications->execute();
        $publications = $coutpublications->rowCount();
        // Returning
        return $publications;
    }

    // Groups function
    function groups(){
        global $db;
        $coutgroups = $db->prepare('SELECT * FROM groups');
            $coutgroups->execute();
        $groups = $coutgroups->rowCount();
        // Returning
        return $groups;
    }

    // Comments function
    function comments(){
        global $db;
        $coutcomments = $db->prepare('SELECT * FROM comments');
            $coutcomments->execute();
        $comments = $coutcomments->rowCount();
        // Returning
        return $comments;
    }

    // Feedback function
    function feedback(){
        global $db;
        $coutfeedback = $db->prepare('SELECT * FROM feedback');
            $coutfeedback->execute();
        $feedback = $coutfeedback->rowCount();
        // Returning
        return $feedback;
    }

    // Get Youtube embed link
    function convertYoutube($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe src=\"//www.youtube.com/embed/$2\" class='flux-video' allowfullscreen></iframe>",
        $string
    );
    }

    // 
    // Starting of point's algo
    // 

    // [(Likes totaux + Dislikes totaux/vues totales) + (Publications totales/jours depuis l'inscription) + (Likes totaux - Dislikes totaux/vues totales) + (commentaires/vues)] x 100

    // Getting user's likes
    function getAllLikes($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($id));
            $countPublications = $getPublications->rowCount();
        $publications = $getPublications->fetchAll();
        // Counting likes
        if($countPublications > 0){
            $getLikes = $db->prepare('SELECT * FROM likes WHERE publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')');
                $getLikes->execute();
            $getAllLikes = $getLikes->rowCount();
        }else{
            $getAllLikes = 0;
        }
        // Returning
        return $getAllLikes;
    }

    // Getting user's dislikes
    function getAllDislikes($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($id));
            $countPublications = $getPublications->rowCount();
        $publications = $getPublications->fetchAll();
        // Counting likes
        if($countPublications > 0){
            $getDislikes = $db->prepare('SELECT * FROM dislikes WHERE publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')');
                $getDislikes->execute();
            $getAllDislikes = $getDislikes->rowCount();
        }else{
            $getAllDislikes = 0;
        }
        // Returning
        return $getAllDislikes;
    }

    // Getting user's shared
    function getAllShared($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($id));
            $countPublications = $getPublications->rowCount();
        $publications = $getPublications->fetchAll();
        // Counting likes
        if($countPublications > 0){
            $getShared = $db->prepare('SELECT * FROM share WHERE publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')');
                $getShared->execute();
            $getAllShared = $getShared->rowCount();
        }else{
            $getAllShared = 0;
        }
        // Returning
        return $getAllShared;
    }

    // Getting user's views
    function getAllViews($id){
        global $db;
        // Counting likes
        $getViews = $db->prepare('SELECT * FROM views WHERE author = ?');
            $getViews->execute(array($id));
        $getAllViews = $getViews->rowCount();
        // Returning
        return $getAllViews;
    }

    // Getting user's publications
    function getAllPublications($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($id));
        $getAllPublications = $getPublications->rowCount();
        // Returning
        return $getAllPublications;
    }

    // Getting user's days
    function getAllDays($id){
        global $db;
        $getFromDate = $db->prepare('SELECT * FROM users WHERE id = ?');
            $getFromDate->execute(array($id));
                $user = $getFromDate->fetch();
                    $date = strtotime($user['creation']);
                $time = time();
            $difference = $time - $date;
        $toReturn = floor($difference / (60 * 60 * 24));
        // Returning
        return $toReturn;
    }

    // Get users's comment
    function getAllComments($id){
        global $db;
        $getPublications = $db->prepare('SELECT * FROM publications WHERE author = ?');
            $getPublications->execute(array($id));
        $publications = $getPublications->fetchAll();
        // Getting comments
        $getComments = $db->prepare('SELECT * FROM comments WHERE publication IN (' . implode(',', array_map('intval', array_column($publications, 'id'))) . ')');
            $getComments->execute(array($id));
        $getAllComments = $getComments->rowCount();
        // Returning
        return $getAllComments;
    }

    // Gettings user's point
    function getAllPoints($id){
        global $db;
        // (Likes totaux + Dislikes totaux/vues totales)
        $totalVotes = getAllLikes($id) + getAllDislikes($id);
        if(getAllViews($id) > 0){
            $firstItem = $totalVotes/getAllViews($id);
        }else{
            $firstItem = 0;
        }
        // (Publications totales/jours depuis l'inscription)
        if(getAllDays($id) > 0){
            $secondItem = getAllPublications($id)/getAllDays($id);
        }else{
            $secondItem = getAllPublications($id);
        }
        // (Likes totaux - Dislikes totaux/vues totales)
        $totalVotes2 = getAllLikes($id) - getAllDislikes($id);
        if(getAllViews($id) > 0){
            $thirdItem = $totalVotes2/getAllViews($id);
        }else{
            $thirdItem = 0;
        }
        // (commentaires/vues)
        if(getAllViews($id) > 0){
            $fourthItem = getAllComments($id)/getAllViews($id);
        }else{
            $fourthItem = 0;
        }
        // (partages/likes)
        if(getAllLikes($id) > 0){
            $fifthItem = getAllShared($id)/getAllLikes($id);
        }else{
            $fifthItem = 0;
        }
        // (partages/vues)
        if(getAllViews($id) > 0){
            $sixtItem = getAllShared($id)/getAllViews($id);
        }else{
            $sixtItem = 0;
        }
        // Calculate user's points
        $points = $firstItem + $secondItem + $thirdItem + $fourthItem + $fifthItem + $sixtItem;
        $userPoints = $points*100;
        // Returning
        return floor($userPoints);
    }
    
    // Week user 's function
    function weekUser(){
        global $db;
        $getUser = $db->prepare('SELECT * FROM users ORDER BY points DESC');
            $getUser->execute();
        $user = $getUser->fetch();
        // Returning
        return $user['id'];
    }

    // Get cateogry's fullname
    function getCatName($cat){
        if($cat == 'default'){
            $fullname = "Tout et n'importe quoi";
        }elseif($cat == 'technology'){
            $fullname = "Technologie";
        }elseif($cat == 'beauty'){
            $fullname = "Beauté & Lifestyle";
        }elseif($cat == 'gaming'){
            $fullname = "Gaming & Jeux vidéos";
        }elseif($cat == 'making'){
            $fullname = "Bricolage & Création";
        }elseif($cat == 'other'){
            $fullname = "Autres";
        }
        return $fullname;
    }
?>