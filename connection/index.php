<?php
session_start();
if(isset($_SESSION['id'])){
	header('Location: ../');
}
	require('../public/php/pdo.php');
	if(isset($_POST['submit'])){
		if(!empty($_POST['email']) AND !empty($_POST['password'])){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$userExit = $db->prepare('SELECT * FROM users WHERE email = ?');
				$userExit->execute(array($_POST['email']));
				$user = $userExit->fetch();
				if($user != 0){
					if(md5($_POST['password']) == $user['password']){
						$_SESSION['id'] = $user['id'];
						$_SESSION['pseudo'] = $user['pseudo'];
						$_SESSION['firstname'] = $user['firstname'];
						$_SESSION['permission'] = $user['permission'];
						$success = 'Connexion ...';
						header('Location: ../');
					}else{
						$error = 'Mot de passe incorrect';
					}
				}else{
					$error = 'Utilisateur inconnu';
				}
			}else{
				$error = 'Adresse e-mail invalide';
			}
		}else{
			$error = 'Tous les champs doivent être complétés';
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo.com  - Connection</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Connectez-vous afin d'accéder à la plateforme.">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://fontawesome.io/assets/font-awesome/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.max.css">
</head>
<body>
	<div class="container">
		<img src="img/kamico.png" alt="kamico" class="kamico">
		<h3 class='title'>Se connecter à Kamevo</h3>
		<?php
				if(isset($_GET['err']) AND $_GET['err'] == 'permission'){
					echo '<div class="error">
						<p class="error-message">Vous devez d\'abord vous connecter</p>
					</div>';
				}
				if(isset($_GET['err']) AND $_GET['err'] == 'disconnected'){
					echo '<div class="error">
						<p class="error-message">Vous êtes désormais déconnecté</p>
					</div>';
				}
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
		<form action="" method="post" class="form">
			<label for="email">Adresse e-mail</label>
			<input type="email" name="email" class="input" id="email">
			<label for="password">Mot de passe</label>
			<input type="password" name="password" class="input" id="password">
			<input type="submit" name="submit" value="Se connecter" class="submit">
		</form>
		<p>Pas encore inscrit ? <a href="../inscription" class="signup">S'inscrire.</a></p>
		<div class="usefuls">
			<div class="useful"><a href="../cgu" class="terms">Conditions générales d'utilisation</a></div>
			<div class="useful">- <a href="../about/" class="terms">Qu'est-ce que Kamevo ?</a></div>
		</div>
	</div>
</body>
</html>