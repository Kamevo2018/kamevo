<?php
session_start();
if(isset($_SESSION['id'])){
    if(isset($_POST['submit'])){
        header('Location: '.$_POST['cat'].'/');
    }
}else{
    header('Location: ../connection/');
}
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../public/php/pdo.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kamevo - Parcourir les catégories</title>
    <meta name="description" content="Trouver les profils les mieux référencés par la communauté Kamevo selon la catégorie de votre choix. Préparez-vous à faire de belles découvertes...">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
    <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
    <link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="../public/fonts.css">
    <link rel="icon" type="image/x-icon" href="../img/kamico.ico" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/roulette.css">
    <link rel="stylesheet" href="../css/style.max.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/post.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
<?php require('../php/menu.php'); ?>
<div class="k-roulette">
    <img src="../img/kamico.png" alt="kamico" class="k-r-kamico">
    <h1 class="title">Parcourir les catégories</h1>
    <p class="desc">Trouver les profils les mieux référencés par la communauté Kamevo selon la catégorie de votre choix. Préparez-vous à faire de belles découvertes...</p>
    <form action="" method="post">
        <br/><label for="cat">Parmi quelle catégorie devons-nous chercher ?</label>
        <select name="cat" id="cat" class="input">
            <option value="default">Tout et n'importe quoi</option>
                <option value="technology">Technologie & Informatique</option>
                    <option value="beauty">Beauté & Lifestyle</option>
                <option value="gaming">Gaming & Jeux vidéos</option>
            <option value="making">Bricolage & Création</option>
        </select>
        <input type="submit" name="submit" class="submit" value="Parcourir la catégorie">
    </form>
</div>
<script type="text/javascript" src="../js/homepage/mobile.js"></script>
<script type="text/javascript" src="../js/ajax/search.js"></script>
</body>
</html>