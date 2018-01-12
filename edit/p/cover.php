<?php
session_start();
if(isset($_SESSION['id'])){
require('../../php/group.functions.php');
require('../../php/global.functions.php');
require('../../php/user.functions.php');
require('../../public/php/pdo.php');
if(isset($_POST['submit'])){
		if ($_FILES['new']['size'] != 0 && $_FILES['new']['error'] == 0){
			$target_dir = "../../img/upload/";
            
			$getFileName = $db->prepare('SELECT * FROM publications');
			$fileNumber = $getFileName->rowCount();
			$image = $fileNumber;
			$image .= basename($_FILES["new"]["name"]);
			$imageName = sha1($image);
			$imageFileType = pathinfo($_FILES["new"]["name"],PATHINFO_EXTENSION);
			// sha1($_SESSION['id'].time()) -> not 2 images with the same name
			$target_file = $target_dir.sha1($_SESSION['id'].time().$_FILES["new"]["name"]).'.'.$imageFileType;
			$uploadOk = 1;
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["new"]["tmp_name"]);
				if($check !== false) {
					$uploadOk = 1;
				} else {
					$postError = 'Il semble que le fichier choisi ne soit pas une image';
					$uploadOk = 0;}
			}
			if ($_FILES["new"]["size"] > 8000000) {
				$postError = 'Votre fichier pèse trop lourd (max. 8Mo)';
				$uploadOk = 0;}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPEG" && $imageFileType != "JPG" && $imageFileType != "PNG") {
				$postError = 'Seuls les fichiers JPG, JPEG, PNG & GIF sont acceptés';
				$uploadOk = 0;}
			if ($uploadOk == 0) {} else {
				if (move_uploaded_file($_FILES["new"]["tmp_name"], $target_file)) {
						if(getUserInfos($_SESSION['id'], "cover") != 'kcover.png'){
							unlink("../../img/upload/".getUserInfos($_SESSION['id'], "cover"));
						}
						$updateAvatar = $db->prepare('UPDATE users SET cover = ? WHERE id = ?');
						$updateAvatar->execute(array($target_file,$_SESSION['id']));
						$postSuccess = 'Votre image de couverture a bien été modifiée';
					} else {$postError = 'Une erreur est survenue';}
				}
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
		<h3 class='title'>Modifier mon image de couverture</h3>
			<?php
				if(isset($postSuccess)){
					echo '<div class="success">
						<p class="success-message">'.$postSuccess.'</p>
					</div>';
				}
				if(isset($postError)){
					echo '<div class="error">
						<p class="error-message">'.$postError.'</p>
					</div>';
				}
		?>
		<form action="" method="post" class="form" enctype="multipart/form-data">
			<label for="new">Nouvelle image de couverture</label>
			<input type="file" name="new" class="input" id="new">
			<input type="submit" name="submit" value="Sauvegarder mes modifications" class="submit">
		</form>
	</div>
<script type="text/javascript" src="/k2/js/homepage/mobile.js"></script>
</body>
</html>