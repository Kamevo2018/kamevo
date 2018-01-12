<?php
session_start();
if(isset($_SESSION['id'])){
	require('../../public/php/pdo.php');
	require('../../php/user.functions.php');
	require('../../php/group.functions.php');
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
			if ($_FILES["new"]["size"] > 2000000) {
				$postError = 'Votre fichier pèse trop lourd (max. 2Mo)';
				$uploadOk = 0;}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$postError = 'Seuls les fichiers JPG, JPEG, PNG & GIF sont acceptés';
                $uploadOk = 0;}
            if(!isset($_POST['author']) AND empty($_POST['content'])){
                $uploadOk = 0;
                $postError = 'Veuillez compléter tous les champs';
            }
			if ($uploadOk != 0) {
				if (move_uploaded_file($_FILES["new"]["tmp_name"], $target_file)) {
                        // $author = $_POST['author'];
                        // $content = $_POST['content'];
						// $updateAvatar = $db->prepare('INSERT INTO publicity (author,content,image) VALUES (?,?,?)');
						// $updateAvatar->execute(array($author,$content,$target_file));
						$postSuccess = 'La publicité est en ligne';
					} else {$postError = 'Une erreur est survenue';}
				}
            } else {

		}
	}
}else{
	header('Location: ../../');
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Kamevo - Mettre en ligne une publicité</title>
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
	<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
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
		<h3 class='title'>Modifier mon image de profil</h3>
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
		<div class="cedit">
			<form action="" method="post" enctype="multipart/form-data">
				<label for="author">Auteur de la publicité</label>
				<input type="text" name="author" class="input" id="author">
				<label for="content">Contenu de la publicité</label>
				<textarea name="content" class="input" id="content" rows="10"></textarea>
				<label for="new">Image liée à la publicité</label>
				<input type="file" name="new" class="input" id="new">
				<input type="submit" name="submit" value="Mettre en ligne la publicité" class="submit">
			</form>
		</div>
	</div>
<script type="text/javascript" src="../../js/homepage/mobile.js"></script>
</body>
</html>