<?php
session_start();
require('../../php/group.functions.php');
require('../../php/global.functions.php');
require('../../php/user.functions.php');
if(isset($_SESSION['id'])){
	if(isset($_POST['submit'])){
		if(!empty($_POST['new'])){
            if(strlen($_POST['new']) < 251){
				require('../../public/php/pdo.php');
				$update = $db->prepare('UPDATE users SET biography = ? WHERE id = ?');
				$update->execute(array(htmlspecialchars($_POST['new']), $_SESSION['id']));
				header('Location: ../../profile/?user='.$_SESSION['id']);
            }else{
                $error = 'Une biographie ne peut pas dépasser 250 caractères';
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
		<h3 class='title'>Modifier ma biographie</h3>
		<?php
				if(isset($error)){
					echo '<div class="error">
						<p class="error-message">'.$error.'</p>
					</div>';
				}
		?>
		<form action="" method="post" class="form">
			<p class="label">Biographie actuelle</p><br/><br/>
			<p class="edit-link ta-left"><?= getUserInfos($_SESSION['id'], 'biography'); ?></p><br/>
			<label for="new">Nouvelle biographie ( max. 250 caractères ) <span id="jq-carac"></span></label>
			<textarea type="text" name="new" class="input" id="new" rows="6"><?php if(isset($_POST['new'])){echo $_POST['new']; } ?></textarea>
			<input type="submit" name="submit" value="Sauvegarder mes modifications" class="submit">
		</form>
	</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#new").keyup(function(){
    $('#jq-carac').html(this.value.length + ' caractère(s)');
  });
});
</script>
<script type="text/javascript" src="/k2/js/homepage/mobile.js"></script>
</body>
</html>