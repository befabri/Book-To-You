<?php 
class LoginController{

    private Db $_db;

    public function __construct($db) {
        $this->_db = $db;
    }
		
	public function run(){	
        $notification='';

        if (!empty($_SESSION['user_id'])) {
            header("Location: index.php?action=profil");
            die(); 
		}

        if (!empty($_POST['form_login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $member = $this->_db->select_members_by_email($_POST['email']);
            // Check the password by comparing hash of bcrypt
            if ($member && $member->is_password_correct($_POST['password'])) {
                if (!$member->is_remove()) {
                    $_SESSION['user_id'] = $member->email();
                    header("Location: index.php");
                    die();
                }
                $notification="Votre compte a été supprimé.";
            } else {
                $notification="Vos données d'authentification ne sont pas correctes.";
            }
        }

		require_once(VIEWS_PATH . 'login.php');
	}
	
} 
?>