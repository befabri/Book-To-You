<?php 
class AdminUserController {

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
        $member = $this->_db->select_members_by_email($_SESSION['user_id']);
        if ($member && !$member->is_admin()) {
            header("Location: index.php?action=login");
            die(); 
        }
        $memberConnectedId = $member->id_member();
        if (!empty($_GET['active']) && !empty($_GET['user']) || !empty($_GET['privilege']) && !empty($_GET['user'])) {
            $member = $this->_db->select_members_by_email($_GET['user']);
            if ($member && $member->id_member() != $memberConnectedId) {
                if (!empty($_GET['active']) && $_GET['active'] == "disable")
                    $this->remove_member($member);
                if (!empty($_GET['privilege']))
                    $this->change_member_privilege($member, $_GET['privilege']);
            }
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
            $members = $this->_db->select_members_all($sort, $_SESSION['sort_order']);
        } else {
            $members = $this->_db->select_members_all();
        }
        require_once(VIEWS_PATH . 'adminUser.php');
    }

    private function change_member_privilege($member, $privilege){
        if ($privilege == "admin" || $privilege == "member" )
            $this->_db->update_members('privilege', $privilege, $member->id_member());
    }

    private function remove_member($member){
        if (!$member->is_remove())
            $this->_db->update_members('active', 0, $member->id_member());
    }
}
?>