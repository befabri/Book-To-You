<?php include 'notificationPopup.php';?>
<div class="idea-container">
	<div id="vote">
		<p><?php echo ($voteCount>1) ? "{$voteCount} votes" : "{$voteCount} vote"?></p>
		<a class="button vote" href="index.php?action=vote&id=<?php echo $idea->html_id_idea()?>"> Voter</a>
	</div>
		
	<article class="content">
		<div class="title"><h1><?php echo $idea->html_title();?></h1>
		<?php echo ($idea->html_status()=="CLOSED")?'<b>'.STATUS[$idea->html_status()].'</b>':STATUS[$idea->html_status()]?></div>
		<p> <?php echo nl2br($idea->html_text());?> </p>
	</article>		
	<div  class='closed'>
	<?php echo ($idea->html_status()=="CLOSED")?"<p><b>L'idée est fermée, vous ne pouvez plus voter mais vous pouvez continuer à la commenter</b></p>":"";?></div>	
</div>
<section id="comment">	
	<h3><?php echo $commentCount;?> <?php echo ($commentCount>1) ? 'commentaires' : 'commentaire';?></h3>
	<div id="add-comment">
		<form method="post" action="index.php?action=idea&id=<?php echo $_GET['id'];?>">
			<textarea name="text" rows="2" maxlength="700">Ajouter un commentaire</textarea>
			<input class="button" type="submit" name="form_comment" value="Poster un commentaire">
		</form> 
	</div>	
	<?php 
		foreach ($comments as $comment) { 
			$text = nl2br($comment->html_text());
			echo "<article class='comment-user'>";
			echo "<div class='comment-details'>";
			echo "<p class='comment-author'><a href='index.php?action=profil&user={$comment->html_username()}'>{$comment->html_username()}</a> - {$comment->html_date_submitted()}</p>";
			echo ($member->html_id_member() == $comment->html_id_member() && $comment->html_deleted()==0)?"<a class='comment-delete' href='index.php?action=idea&id={$idea->html_id_idea()}&comment={$comment->html_id_comments()}&del'>supprimer</a>":"";
			echo "</div>";
			echo ($comment->html_deleted()==0)?"<p class='comment-text'>{$text}</p>":"<p class='comment-text'>ce commentaire a été supprimé</p>";
			echo "</article>";
		}
	?>		
</section>