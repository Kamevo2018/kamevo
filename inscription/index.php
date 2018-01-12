<?php
session_start();
require('../public/php/pdo.php');
if(isset($_SESSION['id'])){
	header('Location: ../');
}
	if(isset($_POST['submit'])){
		if(!empty($_POST['firstname']) AND !empty($_POST['surname']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password2']) AND strlen(trim($_POST['firstname'])) > 0 AND strlen(trim($_POST['surname'])) > 0 AND strlen(trim($_POST['pseudo'])) > 0 AND strlen(trim($_POST['email'])) > 0 AND strlen(trim($_POST['password'])) > 0 AND strlen(trim($_POST['password'])) > 0){
			if($_POST['firstname'] != $_POST['surname']){
				if(strlen(trim($_POST['firstname'])) < 50 AND strlen(trim($_POST['surname'])) < 50){
					if(strlen($_POST['pseudo']) < 50){
						if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
							if($_POST['password'] === $_POST['password2']){
								$checkUser = $db->prepare('SELECT * FROM users WHERE email = ?');
								$checkUser->execute(array($_POST['email']));
								$userExist = $checkUser->fetch();
								if($userExist == 0){
									$checkName = $db->prepare('SELECT * FROM users WHERE pseudo = ?');
									$checkName->execute(array($_POST['pseudo']));
									$nameExist = $checkName->fetch();
									if($nameExist == 0){
										if(isset($_POST['cgu'])){
											$pseudo = htmlspecialchars($_POST['pseudo']);
											$firstname = htmlspecialchars($_POST['firstname']);
											$surname = htmlspecialchars($_POST['surname']);
											$email = $_POST['email'];
											$password = md5($_POST['password']);
											$category = $_POST['category'];
											$insertUser = $db->prepare('INSERT INTO users (pseudo,firstname,surname,email,password,category) VALUES (?,?,?,?,?,?)');
											$insertUser->execute(array($pseudo,$firstname,$surname,$email,$password,$category));
											$insertUser->closeCursor();
											$success = 'Votre compte a bien été créé ! <a href="../connection/" class="s-a">Se connecter</a>';
											$header = "MIME-Version: 1.0\r\n";
											$header.= 'From:"Kamevo.com"<noreply@kamevo.com>'."\n";
											$header.= 'Content-Type:text/html; charset="utf-8"'."\n";
											$header.= 'Content-Transfer-Encoding: 8bit';
											mail($email, '	Suppression de votre compte', 'Bonjour '.$firstname.',<br/><br/> Vous venez de vous inscrire sur Kamevo.com, nous en sommes ravis !<br/>Vous allez maintenant pouvoir utiliser la plateforme et toutes ses fonctionnalités sans limites, nous espérons de tout coeur que vous vous y plairez.<br/> Vous pouvez dès à présent vous connecter en cliquant sur ce lien : https://kamevo.com/connection/.<br/><br/>À votre service,<br/>L\'équipe Kamevo.com', $header);
										}else{
											$error = 'Vous devez accepter les Conditions générales d\'utilisation';
										}
									}else{
										$error = 'Pseudo déjà utilisé';
									}
								}else{
									$error = 'Adresse e-mail déjà utilisée';
								}
							}else{
								$error = 'Les deux mots de passe ne correspondent pas';
							}
						}else{
							$error = 'Adresse e-mail invalide';
						}
					}else{
						$error = 'Le pseudo ne peut pas dépasser les 50 caractères';
					}
				}else{
					$error = 'Le nom ou le prénom ne peut pas dépasser les 50 caractères';
				}
			}else{
				$error = 'Le prénom et le nom de famille ne peuvent pas être identiques';
			}
		}else{
			$error = 'Tous les champs doivent être complétés';
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo.com - Inscription</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Inscrivez-vous pour bénéficier pleinement de la plateforme Kamevo.com et de ses nombreuses fonctionnalités !">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>
	<div class="container">
		<img src="img/kamico.png" alt="kamico" class="kamico">
		<h3 class='title'>S'inscrire sur Kamevo.com</h3>
		<?php
		if(isset($error)){
			echo '<div class="error">
					<p class="error-message">'.$error.'</p>
				</div>';
		}elseif(isset($success)){
			echo '<div class="success">
					<p class="success-message">'.$success.'</p>
				</div>';
		}
		?>
		<form action="" method="post" class="form">
			<div class="inline">
				<label for="firstname">Prénom</label>
				<input type="text" name="firstname" class="iinput" id="firstname" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; } ?>">
			</div>
			<div class="inline">
				<label for="surname">Nom de famille</label>
				<input type="text" name="surname" class="iinput" id="surname" value="<?php if(isset($_POST['surname'])){ echo $_POST['surname']; } ?>">
			</div><br/>
			<div class="inline">
				<label for="pseudo">Pseudonyme</label>
				<input type="text" name="pseudo" class="input" id="pseudo" value="<?php if(isset($_POST['pseudo'])){ echo $_POST['pseudo']; } ?>">
			</div>
			<div class="inline">
				<label for="email">Adresse e-mail</label>
				<input type="email" name="email" class="input" id="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
			</div>
			<div class="inline">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" class="input" id="password">
			</div>
			<div class="inline">
				<label for="password2">Confirmer le mot de passe</label>
				<input type="password" name="password2" class="input" id="password2">
			</div>
			<label for="category">Centres d'intérêts</label>
			<select name="category" id="category">
				<option value="default">Tout et n'importe quoi</option>
				<option value="technology">Technologie & Informatique</option>
				<option value="beauty">Beauté & Lifestyle</option>
				<option value="gaming">Gaming & Jeux vidéos</option>
				<option value="making">Bricolage & Création</option>
				<option value="other">Quelque chose d'autre...</option>
			</select>
			<input type="submit" name="submit" value="Créer mon compte" class="submit">
			<div class="cgu">
				<input type="checkbox" name="cgu" class="checked" id="cgu">
				<label for="cgu" class="label">J'ai lu et j'accepte les <a href="../cgu" class="cgus">Conditions générales d'utilisation</a></label>
			</div>
		</form>
		<p>Déjà inscrit ? <a href="../connection/" class="signup">Se connecter.</a></p>
		<div class="usefuls">
			<div class="useful"><a href="../cgu" class="terms">Conditions générales d'utilisation</a></div>
			<div class="useful">- <a href="../about" class="terms">Qu'est-ce que Kamevo ?</a></div>
		</div>
	</div>
</body>
</html>