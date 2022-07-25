<?php 
class HeaderController{

    private Db $_db;

    public function __construct($db) {
        $this->_db = $db;
    }
		
	public function run(){
        $isAdmin = false;
        $isAuthenticated = false;
        if (!empty($_SESSION['user_id'])){
            $member = $this->_db->select_members_by_email($_SESSION['user_id']);
            $isAuthenticated = true;
            if($member && $member->is_admin()) {
                $isAdmin = true;
            }
        }
        require_once(VIEWS_PATH . 'header.php');
	}	
} 
?>