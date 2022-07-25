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
                    $this->_db->update_ideas_status($_GET['status'],$idea->id_idea());
                }
            }
        }
        $ideas = $this->_db->select_ideas_all(); 
        require_once(VIEWS_PATH . 'adminIdea.php');
    }
    
}

?>