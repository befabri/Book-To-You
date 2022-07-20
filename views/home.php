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
	<?php foreach ($ideas as $idea) { ?>
			<div class="card">
				<article class="card__content">
						<p class="card__status" data-tooltip="<?php echo $idea->html_date_submitted()?>">
							<?php echo STATUS[$idea->html_status()]?>
						</p>
						<div class="card__tooltip">
							
						</div>
					<h2><a href="index.php?action=idea&id=<?php echo $idea->html_id_idea()?>"><?php echo $idea->html_title()?></a></h2>
					<p>
						<?php 
							// Shorten the description of ideas if they exceed 250 characters to a space to not cut out words
							// User can read more by clicking the idea
							$textLimit = 250; 
							if (strlen($idea->html_text()) >= $textLimit) {
									echo substr($idea->html_text(),0,$textLimit+strpos(substr($idea->html_text(),$textLimit)," "));
									echo "...<p><a href='index.php?action=idea&id={$idea->html_id_idea()}'> En lire plus</a></p>";
							} else {
								echo $idea->html_text();
							}
						?>
					</p>
				</article>
				<div class="card__info">
					<a href="index.php?action=idea&id=<?php echo $idea->html_id_idea()?>"><h2><?php echo $idea->html_votes_count()?></h2> <p class="card__info--small"><?php echo ($idea->html_votes_count()>1) ? 'votes' : 'vote'?></p></a>
					<a href="index.php?action=idea&id=<?php echo $idea->html_id_idea()?>#comment"><h2><?php echo $idea->html_comments_count()?></h2> <p class="card__info--small"><?php echo ($idea->html_comments_count()>1) ? 'commentaires' : 'commentaire'?></p></a>
				</div>
				<a class="button vote" href="index.php?action=vote&id=<?php echo $idea->html_id_idea()?>"> Voter</a>	
			</div>
		<?php } ?>
	</div>
</div>

