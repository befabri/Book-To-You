<h1 class=profil-title><?php echo $member->html_username()?> profil</h1>
<div class='profil-container'>
	<h2><?php echo ($nbIdeas>1)?$nbIdeas." Idées":$nbIdeas." Idée";?></h2>
	<div class='profil-content'>
	<?php
		foreach ($ideas as $idea) { 
			$dateSubmitted = ($idea->html_status()=="SUBMITTED")?$idea->html_date_submitted():'';
			$dateAccepted = ($idea->html_status()=="ACCEPTED")?$idea->html_date_accepted():'';
			$dateRefused = ($idea->html_status()=="REFUSED")?$idea->html_date_refused():'';
			$dateClosed = ($idea->html_status()=="CLOSED")?$idea->html_date_closed():'';
			echo "<div class='element'>
					<a href='index.php?action=idea&id={$idea->html_id_idea()}'>
						<p>Votre idée <b><i>[".STATUS[$idea->html_status()]."] {$idea->html_title()}</i></b> 
						du {$dateSubmitted}{$dateAccepted}{$dateRefused}{$dateClosed}</p>
					</a>
				</div>";
		}?>
	</div>
</div>
<div class='profil-container'>
	<h2><?php echo ($nbVotes>1)?$nbVotes." Votes":$nbVotes." Vote";?></h2>
	<div class='profil-content'>
	<?php
		foreach ($votes as $vote) { 
			echo "<div class='element'>
					<a href='index.php?action=idea&id={$vote->html_id_idea()}'>
						<p>Vous avez voté pour <b><i>{$vote->html_title()}</i></b> de {$vote->html_member()}</p>
					</a>
				</div>";
		}?>
	</div>
</div>
<div class='profil-container'>
	<h2><?php echo ($nbComments>1)?$nbComments." Commentaires":$nbComments." Commentaire";?></h2>
	<div class='profil-content'>
	<?php
		foreach ($comments as $comment) { 
			$text = ($comment->html_deleted()==1)?"[Commentaire supprimé] <s>{$comment->html_text()}</s>":$comment->html_text();
				echo "<div class='element'>
						<a href='index.php?action=idea&id={$comment->html_id_idea()}'>
						<p>Pour l'idée <b><i>{$comment->html_idea_title()}</i></b> du {$comment->html_date_submitted()}</p>
						<p><i>{$text}</i></p>
						</a>
					</div>";
		}?>
	</div>
</div>