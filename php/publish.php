<?php
if(isset($_POST['submit'])){
    if(!empty($_POST['content'])){
		// YouTube video
		if(!empty($_POST['youtube'])){
			$regex_pattern = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
			$match;
			if(preg_match($regex_pattern, $_POST['youtube'], $match)){
				$video = convertYoutube($_POST['youtube']);
			}else{
				$video = 'none';
				$postError = 'Merci d\'entrer une URL YouTube valide !';
		}}else{$video = 'none';}
		// Image
		if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0){
			$target_dir = "../../img/upload/";
			$Realtarget_dir = "img/upload/";
			$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
			$target_file = $target_dir.sha1($_SESSION['id'].time().$_FILES["image"]["name"]).'.'.$imageFileType;
			$Realtarget_file = $Realtarget_dir.sha1($_SESSION['id'].time().$_FILES["image"]["name"]).'.'.$imageFileType;
			$uploadOk = 1;
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["image"]["tmp_name"]);
				if($check !== false) {
					$uploadOk = 1;
				} else {
					$postError = 'Il semble que le fichier choisi ne soit pas une image';
					$uploadOk = 0;}
			}
			if ($_FILES["image"]["size"] > 8000000) {
				$postError = 'Votre fichier pèse trop lourd (max. 8Mo)';
				$uploadOk = 0;}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPEG" && $imageFileType != "JPG" && $imageFileType != "PNG") {
				$postError = 'Seuls les fichiers JPG, JPEG, PNG & GIF sont acceptés';
				$uploadOk = 0;}
			if ($uploadOk == 0) {} else {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $Realtarget_file)) {
						$image = $_FILES["image"]["name"];
					} else {$postError = 'Une erreur est survenue';}
				}
		}else{
			$target_file = 'none';
		}
		if($video != 'none' AND $image != 'none'){
			$postError = 'Vous ne pouvez pas publier une image ET une vidéo';
		}

		if(isset($postError)){}else{
			$insertPublication = $db->prepare('INSERT INTO publications (author,content,video,image,category,target) VALUES (?,?,?,?,?,?)');
			$insertPublication->execute(array($_SESSION['id'], htmlspecialchars($_POST['content']), $video, $target_file, $_POST['cat'],htmlspecialchars($_POST['group'])));
			$insertPublication->closeCursor();
			$postSuccess = 'Vous venez de publier sur Kamevo.com ! <b>Merci.</b>';
		}
    }else{
        $postError = 'Une publication doit contenir du contenu';
    }
}
?>