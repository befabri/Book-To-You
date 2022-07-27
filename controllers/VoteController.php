<?php 
class VoteController {

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
			if ($idea) {
				switch ($idea->html_status()) {
					case 'CLOSED':
						$notification = "Erreur : Les votes sont terminés";
						break;  
					case 'REFUSED':
						$notification = "Erreur : L'idée est refusée";
						break;
					case 'SUBMITTED':
						$notification = "Erreur : L'idée doit être acceptée pour pouvoir être votée";
						break;  
					case 'ACCEPTED':
						// Verify that the status of idea is accepted for voting and the user is not author of idea
						$member = $this->_db->select_members_by_email($_SESSION['user_id']);
						if ($idea->html_id_member() != $member->html_id_member()) {
							if (!$this->_db->exists_votes($_GET['id'], $member->html_id_member())) {
								$this->_db->insert_votes($_GET['id'], $member->html_id_member());
								$notification = "Votre vote a été ajouté";
							} else {
								$notification = "Erreur : Vous avez déjà voté cette idée";
							}
						} else {
							$notification = "Erreur : Vous ne pouvez pas voter pour votre propre idée";
						}
						break;
					default:
						break;
				}
			}
			$_SESSION['notification'] = $notification;
		}
		header("Location: index.php");
		die(); 
	}
}
?>

