<?php
session_start();
if($_SESSION['permission'] == 'admin'){
	require('../../../public/php/pdo.php');
	require('../../../php/user.functions.php');
	require('../../../php/group.functions.php');
	require('../../../php/global.functions.php');
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
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<link rel="stylesheet" href="../css/style.max.css">
	<link rel="stylesheet" href="../css/message.css">
	<link rel="stylesheet" href="../../../css/style.max.css">
	<link rel="stylesheet" href="../../../css/menu.css">
	<link rel="stylesheet" href="../../../css/responsive.css">
	<link rel="stylesheet" href="../css/responsive.css">
	<link rel="stylesheet" href="../../../public/fonts.css">
</head>
<body>
<?php require('../../../php/menu.php'); ?>
	<?php
		if(isset($_GET['message'])){
			$messageExist = $db->prepare('SELECT * FROM feedback WHERE id = ? ORDER BY id DESC');
			$messageExist->execute(array(htmlspecialchars($_GET['message'])));
			$exist = $messageExist->rowCount();
			if($exist > 0){
				while($message = $messageExist->fetch()){
					echo '<div class="message">
						<div class="message-header"><i class="fa fa-user" aria-hidden="true"></i> Message de : <b>'.getUserInfos($message['author'], 'firstname').' '.getUserInfos($message['author'], 'surname').'</b> - Le 07/11/2017</div><br/>
						<p><b>'.$message['message'].'</b></p>
					</div>';
				}
			}else{
				header('Location: ../');
			}
		}else{
			header('Location: ../');
		}
	?>
 <script src="/k2/js/homepage/mobile.js"></script>
</body>
</html>