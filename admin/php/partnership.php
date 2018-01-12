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
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../../css/style.max.css">
	<link rel="stylesheet" href="../../css/menu.css">
	<link rel="stylesheet" href="../../css/responsive.css">
</head>
<body>
<?php require('../../php/menu.php'); ?>
 	 <div class="container">
		<h3 class='title'>Retour des utilisateurs</h3>
		<div class="cedit">
            <p class="label">Demandes de partenariats ou relatives aux droits d'auteurs :</p><br/><br/>
			<?php
				$getPartners = $db->prepare('SELECT * FROM partnership ORDER BY id DESC');
                $getPartners->execute();
				while($partner = $getPartners->fetch()){
					echo '<a href="partnership_message.php?message='.$partner['id'].'" class="edit-link"><div class="fullwidth"><i class="fa fa-envelope" aria-hidden="true"></i> De : '.$partner['email'].' - Le '.date(" d M Y", strtotime($partner['creation'])).'</div></a>';
				}
			?>
		</div>
	</div>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>