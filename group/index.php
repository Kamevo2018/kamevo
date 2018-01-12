<?php
session_start();
require('../php/group.functions.php');
require('../php/user.functions.php');
require('../php/global.functions.php');
if(isset($_SESSION['id'])){
	if(isset($_POST['submit'])){
		if(!empty($_POST['group']) AND !empty($_POST['type'])){
			if(strlen(trim($_POST['description'])) < 300 AND strlen(trim($_POST['description'])) > 150){
				if($_POST['group'] !== $_POST['description']){
					if(strlen($_POST['group']) < 100){
						require('../public/php/pdo.php');
						$groupExist = $db->prepare('SELECT * FROM groups WHERE name = ?');
						$groupExist->execute(array(htmlspecialchars($_POST['group'])));
						$exist = $groupExist->rowCount();
						if($exist == 0){
							$group = htmlspecialchars($_POST['group']);
							$description = htmlspecialchars($_POST['description']);
							$type = $_POST['type'];
							$createGroup = $db->prepare('INSERT INTO groups (name,description,author,type) VALUES (?,?,?,?)');
							$createGroup->execute(array($group,$description,$_SESSION['id'],$type));
							$createGroup->closeCursor();
							$getId = $db->prepare('SELECT * FROM groups');
							$getId->execute();
							$id = $getId->rowCount();
							$target = $id++;
							$insertMember = $db->prepare('INSERT INTO members (page,profile) VALUES (?,?)');
							$insertMember->execute(array($target, $_SESSION['id']));
							header('Location: ../page/?group='.$target);
						}else{
							$error = 'Le nom du groupe est déjà utilisé';
						}
					}else{
						$error = 'Le nom de votre ne groupe ne peut pas dépasser les 100 caractères';
					}
				}else{
					$error = 'La description ne peut pas être identique au nom';
				}
			}else{
				$error = 'Une description doit contenir entre 150 et 300 caractères';
			}
		}else{
			$error = 'Veuillez compléter tous les champs';
		}
	}
}else{
	header('Location: ../');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Créer un groupe</title>
	<link rel="icon" type="image/x-icon" href="https://kamevo.com/img/kamico.ico" />
	<meta name="description" content="Kamevo.com - Créez un groupe afin de rassembler une communauté autour d'un sujet qui vous lient !">
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
		<!-- <img src="../img/kamico.png" alt="kamico" class="kamico"> -->
		<h3 class='title'>Créer un groupe</h3>
			<?php
				if(isset($success)){
					echo '<div class="success">
						<p class="success-message">'.$success.'</p>
					</div>';
				}elseif(isset($error)){
					echo '<div class="error">
						<p class="error-message">'.$error.'</p>
					</div>';
				}else{}
			?>
		<div class="cedit">
			<p class="label">Qu'est-ce qu'un groupe Kamevo ?</p>
			<br/>
			<div class="group-description">
				<p>Un groupe Kamevo vous permettra de rassembler une communauté autour d'un sujet précis. Tous les membres du groupe pourront publier dedans et voir les publications des autres membres.</p>
			</div>
			<form action="" method="post">
				<label for="group">Nom du groupe</label>
				<input type="text" name="group" class="input" id="group">
				<label for="description">Description du groupe ( entre 150 et 300 caractères ) : <span id="jq-carac"></span></label>
				<textarea name="description" id="description" class="input" rows="4"></textarea>
				<label for="type">Que représente votre groupe ?</label>
				<select name="type" id="type">
					<option value="community">Une communauté</option>
					<option value="person">Une personne ou personnalité</option>
					<option value="association">Un organisme/une association</option>
					<option value="society">Une entreprise</option>
				</select>
				<input type="submit" name="submit" value="Créer le groupe" class="submit">
			</form>
		</div>
	</div>
<script>
$(document).ready(function(){
  $("#description").keyup(function(){
    $('#jq-carac').html(this.value.length + ' caractère(s)');
  });
});
</script>
<script type="text/javascript" src="../js/homepage/mobile.js"></script>
<script type="text/javascript" src="js/ajax/search.js"></script>
</body>
</html>