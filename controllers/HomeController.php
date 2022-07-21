<?php 
class HomeController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "";
		if (empty($_SESSION['user_id'])) {
			header("Location: index.php?action=login");
			die(); 
		}
		// Unset session notification if is not empty
		if (isset($_SESSION['notification']) && $_SESSION['notification']!="") {
			$notification = $_SESSION['notification'];
			unset($_SESSION["notification"]);
		}

		// Insert the idea with the datetime in the db if receive the HTTP POST method with the form_idea, title and text attribute
		if (!empty($_POST['form_idea']) && !empty($_POST['title']) && !empty($_POST['text'])) {
			date_default_timezone_set('Europe/Brussels');
			$datetime = date("Y-m-d H:i:s");
			$member = $this->_db->select_members_by_email($_SESSION['user_id']);
			$this->_db->insert_ideas($_POST['title'],$_POST['text'],"SUBMITTED",$datetime,$member->id_member());
			$notification = "Idée ajoutée";
		}

		$page = 1;
		$display = 40;
		if (!empty($_GET['page'])) {
			$page = $_GET['page'];
		}

		// Filter the ideas to display on the main page by status
		if (!empty($_GET['form_filter']) && !empty($_GET['display']) && !empty($_GET['sort'])) {
			$sort = "";
			$submitted=isset($_GET['submitted'])?"SUBMITTED":false;
			$accepted=isset($_GET['accepted'])?"ACCEPTED":false;
			$refused=isset($_GET['refused'])?"REFUSED":false;
			$closed=isset($_GET['closed'])?"CLOSED":false;
			if ($_GET['display'] =="3" || $_GET['display'] =="10")
				$display = $_GET['display'];
			if ($_GET['sort'] =="date" || $_GET['sort'] =="vote")
				$sort = $_GET['sort'];
			$offset = ($page-1) * $display;
			var_dump($offset);
			$ideas = $this->_db->select_ideas_all($offset,$display,$sort,$submitted,$accepted,$refused,$closed);
		} else {
			$offset = ($page-1) * $display; 
			$ideas = $this->_db->select_ideas_all($offset,$display);
		}

		$pages = $this->_db->count_ideas();
		$pages = ceil($pages / $display);

		if (!empty($ideas)) {
			require_once(VIEWS_PATH . 'home.php');
		} else {
			require_once(VIEWS_PATH . 'homeEmpty.php');
		}
	}
}
?>