<?php 
class AdminIdeaController {

    private Db $_db;
        
    public function __construct($db){    
        $this->_db = $db;
    }
    
    public function run() {    
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            die(); 
        }
        $member = $this->_db->select_members_by_email($_SESSION['user_id']);
        if ($member && !$member->is_admin()) {
            header("Location: index.php?action=login");
            die(); 
        }
        if (!empty($_GET['status']) && !empty($_GET['idea'])) {
            $idea = $this->_db->select_ideas($_GET['idea']);
            if($idea && $idea->is_valid_status($_GET['status']))
                $this->change_idea_status($idea, $_GET['status']);
        }
        if (!empty($_GET['sort'])) {
			$sort = $_GET['sort'];
            if (!empty($_SESSION['sort_order'])) {
                if ($_SESSION['sort_order'] == "asc")
                    $_SESSION['sort_order'] = "desc";
                else
                    $_SESSION['sort_order'] = "asc";
            } else {
                $_SESSION['sort_order'] = "asc";
            }
            if ($sort == "comment")
            {
                $ideas = $this->_db->select_ideas_all();
                $ideas = $this->sort_comment($ideas, $_SESSION['sort_order']);
            } else {
                $ideas = $this->_db->select_ideas_all("", $sort, $_SESSION['sort_order']);
            }
        } else {
            $ideas = $this->_db->select_ideas_all();
        }
        require_once(VIEWS_PATH . 'adminIdea.php');
    }

    private function change_idea_status(Idea $idea, string $status) {
        if ($idea->change_status(strtoupper($status))) {
            date_default_timezone_set('Europe/Brussels');
            $datetime = date("Y-m-d H:i:s");
            $this->_db->update_ideas_status($status,$idea->id_idea(),$datetime);
        }
    }

    private function sort_comment($array, $order="asc")
    {
        usort($array, function($a, $b) use ($order) {
            if($order == "asc")
                return $a->comments_count() > $b->comments_count();
            else
                return $a->comments_count() < $b->comments_count();
        });
        return $array;
    }
}

?>