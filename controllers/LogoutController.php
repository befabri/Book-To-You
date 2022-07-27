<?php 
class LogoutController{

    public function __construct() {
    }
		
	public function run(){	
        // Empty the session to disconnect the user and redirect to the connection page
        unset($_SESSION['user_id']);
        header("Location: index.php?action=login");
        die();
	}
	
} 
?>