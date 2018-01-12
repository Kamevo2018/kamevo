<?php
session_start();
require('../public/php/pdo.php');
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../php/global.functions.php');
if(isset($_SESSION['id'])){
	if(isset($_POST['submit'])){
		if(!empty($_POST['message'])){
		if(strlen($_POST['message']) < 2500){
			$checkDone = $db->prepare('SELECT * FROM feedback WHERE author = ?');
			$checkDone->execute(array($_SESSION['id']));
			$done = $checkDone->rowCount();
			if($done == 0){
				$message = htmlspecialchars($_POST['message']);
				$sendMessage = $db->prepare('INSERT INTO feedback (author,message,type) VALUES (?,?,?)');
				$sendMessage->execute(array($_SESSION['id'], nl2br($message), htmlspecialchars($_POST['type'])));
				$success = 'Merci de votre retour, nous en tiendrons compte';
			}else{
				$error = 'Vous nous avez déjà donné votre avis';
			}
		}else{
			$error = 'Votre message ne peut pas dépasser les 2500 caractères';
		}
		}else{
			$error = 'Votre message ne peut pas être vide';
		}
	}
}else{
	header('Location: ../');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Donnez nous votre avis</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Donnez-nous votre avis afin de nous aider à améliorer la plateforme Kamevo.com.">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
<?php require('../php/menu.php'); ?>
	<div class="container">
		<h3 class='title'>Votre avis nous intéresse !</h3>
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
			<p class="label">A quoi sert cette page ?</p>
			<br/>
			<div class="group-description">
				<p>Vous avez un avis ou une suggestion à nous transmettre ? Nous sommes preneurs ! Chaque utilisateur à le droit d'utiliser ( une seule fois ) ce formulaire afin de nous faire part d'un message qu'il juge utile à la plateforme.</p>
			</div>
			<form action="" method="post">
				<label for="message">Votre message :</label>
				<textarea name="message" id="description" class="input" rows="15"><?php if(isset($_POST['message'])){ echo $_POST['message']; }  ?></textarea>
				<label for="type">Votre message est-il un avis, une suggestion ou quelque chose d'autre ?</label>
				<select name="type" id="type">
					<option value="opinion">Un avis/une opinion sur la plateforme</option>
					<option value="person">Une suggestion pour nous améliorer</option>
					<option value="other">Autre chose ...</option>
				</select>
				<input type="submit" name="submit" value="Transmettre mon message" class="submit">
			</form>
		</div>
	</div>
	<script src="js/ajax/search.js" type="text/javascript"></script>
	<script type="text/javascript" src="../js/homepage/mobile.js"></script>
</body>
</html>