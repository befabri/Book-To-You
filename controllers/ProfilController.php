<?php 
class ProfilController {

	private Db $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	   
		if (empty($_SESSION['user_id'])) {
			header("Location: index.php?action=login");
			die(); 
		}
		if (!empty($_GET['user'])) {
			$member = $this->_db->select_members_by_username($_GET['user']);
			if (!$member) {
				header("Location: index.php?action=profil"); // 404
				die(); 
			}
		} else {
			$member = $this->_db->select_members_by_email($_SESSION['user_id']);
		}
		
		$comments = $this->_db->select_comments_all('', $member->id_member());
		$nbComments = count($comments);
		$ideas = $this->_db->select_ideas_all_by_member($member->id_member());
		$nbIdeas = count($ideas);
		$votes = $this->_db->select_votes_all_by_member($member->id_member());
		$nbVotes = count($votes);
		require_once(VIEWS_PATH . 'profil.php');
	}
}
?>