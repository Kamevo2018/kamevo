<?php
session_start();
if($_SESSION['permission'] == 'admin'){
	require('../../public/php/pdo.php');
	require('../../php/user.functions.php');
    require('../../php/group.functions.php');
    require('../../php/global.functions.php');
}else{
	header('Location: ../../');
}
?>
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
	<link rel="stylesheet" href="css/style.max.css">
	<link rel="stylesheet" href="../../css/style.max.css">
	<link rel="stylesheet" href="../../css/menu.css">
	<link rel="stylesheet" href="../../css/responsive.css">
</head>
<body>
<?php require('../../php/menu.php'); ?>
 	 <div class="container">
		<h3 class='title'>Retour des utilisateurs</h3>
		<div class="cedit">
			<?php
				if(isset($_GET['type'])){
					if($_GET['type'] == 'opinion' OR $_GET['type'] == 'suggestion' OR $_GET['type'] == 'other'){
						$getOpinions = $db->prepare('SELECT * FROM feedback WHERE type = ?');
						$getOpinions->execute(array($_GET['type']));
						echo '<p class="label">Type des messages : '.$_GET['type'].'</p><br/><br/>';
						while($opinion = $getOpinions->fetch()){
							echo '<a href="php/message.php?message='.$opinion['id'].'" class="edit-link"><div class="fullwidth"><i class="fa fa-user" aria-hidden="true"></i> '.getUserInfos($opinion['author'], 'firstname').' '.getUserInfos($opinion['author'], 'surname').' - Le '.date(" d M Y", strtotime($opinion['creation'])).'</div></a>';
						}
					}else{
					echo '<p class="label">Quels retours voulez-vous voir ?</p><br/><br/>
					<a href="?type=opinion" class="edit-link"><div class="fullwidth"><i class="fa fa-heart" aria-hidden="true"></i> - Avis/opinions sur la plateforme</div></a>
					<a href="?type=suggestion" class="edit-link"><div class="fullwidth"><i class="fa fa-pencil" aria-hidden="true"></i> - Suggestions pour la plateforme</div></a>
					<a href="?type=other" class="edit-link"><div class="fullwidth"><i class="fa fa-mouse-pointer" aria-hidden="true"></i> - Autres</div></a>';
					}
				}else{
					echo '<p class="label">Quels retours voulez-vous voir ?</p><br/><br/>
					<a href="?type=opinion" class="edit-link"><div class="fullwidth"><i class="fa fa-heart" aria-hidden="true"></i> - Avis/opinions sur la plateforme</div></a>
					<a href="?type=suggestion" class="edit-link"><div class="fullwidth"><i class="fa fa-pencil" aria-hidden="true"></i> - Suggestions pour la plateforme</div></a>
					<a href="?type=other" class="edit-link"><div class="fullwidth"><i class="fa fa-mouse-pointer" aria-hidden="true"></i> - Autres</div></a>';
				}
			?>
		</div>
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>