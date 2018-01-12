<?php
require('../public/php/pdo.php');
require('../php/user.functions.php');
require('../php/group.functions.php');
require('../php/global.functions.php');
	if(isset($_POST['submit'])){
		if(!empty($_POST['message']) AND !empty($_POST['email']) AND strlen(trim($_POST['message'])) > 0 AND strlen(trim($_POST['email'])) > 0){
		if(strlen($_POST['message']) < 5000){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$message = htmlspecialchars($_POST['message']);
				$email = htmlspecialchars($_POST['email']);
				$sendMessage = $db->prepare('INSERT INTO partnership (email,message) VALUES (?,?)');
				$sendMessage->execute(array($email,$message));
				$success = 'Votre message a été transféré, nous vous répondrons dès que possible';
			}else{
				$error = 'Adresse e-mail invalide';
			}
		}else{
			$error = 'Votre message ne peut pas dépasser les 5000 caractères';
		}
		}else{
			$error = 'Votre message ou votre adresse e-mail ne peut pas être vide';
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Partenariat et Droits d'auteurs</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Via cette page, contactez l'administrateur de Kamevo.com ( Axel De Sutter ) afin de proposez un partenariat ou une de faire une demande relative aux droits d'auteurs.">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100|Open+Sans" rel="stylesheet">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../feedback/css/style.max.css">
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
				<p>Vous pensez avoir une bonne raison de contacter l'administrateur de Kamevo.com ( Axel De Sutter ) pour un partenariat ou une question de droits d'auteurs ? C'est ici que ça se passe ! Envoyez nous une demande et nous vous répondrons par mail.<br/>Merci de ne pas abuser de cette fonctionnalité.</p>
			</div>
			<form action="" method="post">
				<label for="email">Votre adresse mail :</label>
				<input type="email" name="email" id="email" class="input">
				<label for="message">Votre demande ( Attention ! Demande sérieuse uniquement ) :</label>
				<textarea name="message" id="description" class="input" rows="15"><?php if(isset($_POST['message'])){ echo $_POST['message']; }  ?></textarea>
				<input type="submit" name="submit" value="Transférer ma demande" class="submit">
			</form>
		</div>
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>