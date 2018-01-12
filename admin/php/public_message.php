<?php
session_start();
if($_SESSION['permission'] == 'admin'){
    require('../../public/php/pdo.php');
    require('../../php/user.functions.php');
    require('../../php/group.functions.php');
    require('../../php/global.functions.php');
    if(isset($_POST['submit'])){
        if(!empty($_POST['title'])){
			if(!empty($_POST['content'])){
				$insertData = $db->prepare('INSERT INTO publicmessage (title,content,duration) VALUES (?,?,?)');
				$insertData->execute(array(htmlspecialchars($_POST['title']),$_POST['content'],time()+intval($_POST['duration'])));
				$success = 'Message publié sur la page d\'accueil';
			}else{
				$error = 'Vous n\'avez pas saisi de contenu';
			}
		}else{
			$error = 'Vous n\'avez pas saisi de titre';
		}
	}
}else{
	header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Administration - Kamevo.com</title>
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../../css/style.max.css">
	<link rel="stylesheet" href="../../css/menu.css">
	<link rel="stylesheet" href="../../css/responsive.css">
</head>
<body>
<?php require('../../php/menu.php'); ?>
	<div class="container">
		<h3 class='title'>Espace d'administration</h3>
		    <?php
				if(isset($success)){
					echo '<div class="success">
						<p class="success-message">'.$success.'</p>
					</div>';
				}
				if(isset($error)){
					echo '<div class="error">
						<p class="error-message">'.$error.'</p>
					</div>';
				}
			?>
		<div class="cedit">
			<p class="label"><i class="fa fa-pencil" aria-hidden="true"></i> Écrire un message sur la page d'accueil</p><br/><br/>
			<form action="" method="post">
				<label for="title"> Titre :</label>
				<input type="text" class="input" id="title" name="title">
				<label for="content"> Contenu :</label>
				<textarea name="content" id="content" class="input" rows="20"></textarea>
				<label for="duration"> Durée de vie du message ( en secondes ) :</label>
				<input type="text" class="input" id="duration" name="duration">
				<input type="submit" class="submit" value="Publier le message" name="submit">
			</form>
		</div>
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>