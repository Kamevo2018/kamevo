<?php
session_start();
require('../../php/group.functions.php');
require('../../php/global.functions.php');
require('../../php/user.functions.php');
if(isset($_SESSION['id'])){
	if(isset($_POST['submit'])){
		if(!empty($_POST['new'])){
			if($_POST['new'] !== $_SESSION['pseudo']){
				require('../../public/php/pdo.php');
				$nameExist = $db->prepare('SELECT * FROM users WHERE pseudo = ?');
				$nameExist->execute(array(htmlspecialchars($_POST['new'])));
				$ifNameExist = $nameExist->rowCount();
				if($ifNameExist == 0){
					$update = $db->prepare('UPDATE users SET pseudo = ? WHERE id = ?');
					$update->execute(array(htmlspecialchars($_POST['new']), $_SESSION['id']));
					$_SESSION['pseudo'] = htmlspecialchars($_POST['new']);
					header('Location: ../../profile/?user='.$_SESSION['id']);
				}else{
					$error = 'Ce pseudo est déjà attribué à un autre utilisateur';
				}
			}else{
				$error = 'Nouveau pseudo identique à l\'actuel';
			}
		}else{
			$error = 'Merci de complèter tous les champs';
		}
	}
}else{
	header('Location: ../connection/');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Modifier mes informations</title>
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
		<img src="../../img/kamico.png" alt="kamico" class="kamico">
		<h3 class='title'>Modifier mon pseudo</h3>
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
		<form action="" method="post" class="form">
			<label for="readonly">Pseudo actuel</label>
			<input type="text" name="actual" class="input" id="readonly" readonly="readonly" value="<?= $_SESSION['pseudo']; ?>">
			<label for="new">Nouveau pseudo</label>
			<input type="text" name="new" class="input" id="new">
			<input type="submit" name="submit" value="Sauvegarder mes modifications" class="submit">
		</form>
	</div>
<script type="text/javascript" src="/k2/js/homepage/mobile.js"></script>
</body>
</html>