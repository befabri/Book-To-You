<?php 
class AdminUserController {

    private $_db;
        
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
        if($member && !$member->is_admin()) {
            header("Location: index.php?action=login");
            die(); 
        }
        
        if (!empty($_GET['active']) && !empty($_GET['member']) || !empty($_GET['privilege']) && !empty($_GET['member'])) {
            $member = $this->_db->select_members_by_email($_GET['member']);
            if($member) {
                if (!empty($_GET['active']) && $_GET['active'] == "disable") {
                    $this->_db->update_members('active',0,$member->id_member());
                }
                if (!empty($_GET['privilege'])) {
                    if ($_GET['privilege'] == "admin" || $_GET['privilege'] == "member" ) {
                        $this->_db->update_members('privilege',$_GET['privilege'],$member->id_member());
                    } 
                }
            }
        }

        $members = $this->_db->select_members_all();
        require_once(VIEWS_PATH . 'adminUser.php');
    }
}
?>