<?php 
class IdeaController {

	private Db $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification="";
		if (empty($_SESSION['user_id'])) {
			header("Location: index.php?action=login");
			die(); 
		}

		if (!empty($_GET['id'])) {
			$idea = $this->_db->select_ideas($_GET['id']);  
			if(!$idea){
				header("Location: index.php");
				die();
			}
			$member = $this->_db->select_members_by_email($_SESSION['user_id']);
			$commentCount = $this->_db->count_comments($idea->id_idea());

			// Remove the user comment if exist if receive the HTTP GET method with the comment and del attribute
			if (!empty($_GET['comment']) && empty($_GET['del']) && $commentCount>0) {
				if ($this->remove_comment($_GET['comment'], $member->id_member(), $idea->id_idea())) {
					header("Location: index.php?action=idea&id={$idea->id_idea()}");
					die();
				}
			}

			// Insert the user comment in the db if receive the HTTP POST method with the form_comment and text attribute
			if (!empty($_POST['form_comment']) && !empty($_POST['text'])) {
				$this->add_comment($_POST['text'], $member->id_member(), $idea->id_idea());
				$notification = "Commentaire ajouté";
			}

			$voteCount = $this->_db->count_votes($idea->id_idea());
			$comments = $this->_db->select_comments_all($idea->id_idea());
			require_once(VIEWS_PATH . 'idea.php');

		} else {
			header("Location: index.php");
			die();
		}
	}
	private function add_comment($text, $memberId, $ideaId) {
		date_default_timezone_set('Europe/Brussels');
		$datetime = date("Y-m-d H:i:s");
		$this->_db->insert_comments($text, $datetime, $memberId, $ideaId);
	}

	private function remove_comment($comment, $memberId, $ideaId) {
		if ($this->_db->exists_comments($comment, $memberId, $ideaId)) {
			$this->_db->remove_comments($comment);
			return true;
		}
		return false;
	}
}
?>