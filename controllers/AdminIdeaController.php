<?php 
class AdminIdeaController {

    private Db $_db;
        
    public function __construct($db){    
        $this->_db = $db;
    }
    
    public function run(){    
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            die(); 
        }
        $member = $this->_db->select_members_by_email($_SESSION['user_id']);
        if($member && !$member->is_admin()) {
            header("Location: index.php?action=login");
            die(); 
        }

        if (!empty($_GET['status']) && !empty($_GET['idea'])) {
            if ($_GET['status'] == "accepted" || $_GET['status'] == "refused"  || $_GET['status'] == "closed"  || $_GET['status'] == "submitted" ) {
                $idea = $this->_db->select_ideas($_GET['idea']);
                if($idea && $idea->change_status(strtoupper($_GET['status']))) {
                    date_default_timezone_set('Europe/Brussels');
			        $datetime = date("Y-m-d H:i:s");
                    $this->_db->update_ideas_status($_GET['status'],$idea->id_idea(),$datetime);
                }
            }
        }
        $sort = $url = $order ="";
        if (!empty($_GET['sort'])) {
            if (empty($_GET['sorting'])){
                $url ="&sorting=asc";
                $order = "asc";
            }
            else{
                $_GET['sorting'] = $_GET['sorting'] == "desc" ? "asc" : "desc";
                $url = "&sorting=".$_GET['sorting'];
                $order = $_GET['sorting'];
            }
			$sort = $_GET['sort'];
        }
        $ideas = $this->_db->select_ideas_all("", $sort, $order);
        require_once(VIEWS_PATH . 'adminIdea.php');
    }


}

?>