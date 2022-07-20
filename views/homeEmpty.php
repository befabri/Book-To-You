<?php include 'notificationPopup.php';?>
<div class="banner">
	<img src="<?php echo VIEWS_PATH ?>images/banner.png" alt="banner">
	<div class="top">
		<h1>Avec BookToYou </h1>
	</div>
	<div class="centered">
		<h2>Les <div class="banner-hide">livres </div><div class="space"></div>s'offrent à vous</h2>
	</div>
</div>
<div class="add-idea">
<h2>Ajouter une idée</h2>
	<form method="post" action="index.php">
		<div id="title">
			<input type="text" name="title" maxlength="80" value="Mon titre">
			<input class="button" type="submit" name="form_idea" value="Poster une idée">
		</div>
		<textarea name="text" rows="4" maxlength="1200">Ajouter une idée</textarea>
	</form>
</div>	
<div id="idea-container">
	<?php include 'aside.php';?>
	<div id="ideas-grid">
		<p>Aucune idée trouvée</p>
	</div>
</div>
		

