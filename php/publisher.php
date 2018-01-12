<div class="post">	
	<div class="darkness"></div>
	<form action="" method="post"  enctype="multipart/form-data">
		<div class="post-content">
			<label for="post-content">Contenu de la publication :<span class="right">&times;</span></label>
			<textarea name="content" id="post-content"></textarea>
			<span class="post-option">Options supplémentaires :</span><br/><br/>
			<label for="group">- Publier dans un groupe dont vous faites partie ? :</label>
			<select name="group" id="group" class="input">
				<option value="default">Non</option>
				 <?php
					$getGroups = $db->prepare('SELECT * FROM members WHERE profile = ?');
					$getGroups->execute(array($_SESSION['id']));
					while($group = $getGroups->fetch()){
						 echo '<option value="'.$group['page'].'">'.getGroupInfos($group['page'], 'name').'</option>';
					}
				?> 
			</select>
			<label for="post-youtube">- Lier une vidéo YouTube à la publication :</label>
			<input type="text" name="youtube" class="input">
			<label for="image">- Ajouter une image à la publication (Jpeg/Png) :</label>
			<input type="file" name="image" class="input" id="image">
			<label for="post-cat">- Insérer votre publication dans une catégorie :</label>
			<select name="cat" id="post-cat" class="input">
				<option value="default">Non merci</option>²
				<option value="technology">Tehnologie</option>
				<option value="gaming">Gaming</option>
				<option value="beauty">Beauté/Lifestyle</option>
				<option value="makers">Artisanat/Bricolage</option>
				<option value="music">Musique</option>
			</select>
			<input type="submit" value="Publier sur Kamevo" class="submit" name="submit">
		</div>
	</form>
</div>