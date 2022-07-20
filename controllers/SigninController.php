<?php 
class SigninController{

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }
		
	public function run(){	
		$notification='';

        if (!empty($_SESSION['user_id'])) {
			header("Location: index.php?action=profil");
			die(); 
		}

        if (!empty($_POST['form_signin']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {
            $member = $this->_db->select_members_by_email($_POST['email']);
            if ($member) {
                $notification = "L'adresse email est déjà prise";
            } elseif  ($this->_db->exists_username($_POST['username'])) {
                $notification = 'Username existe deja';
            } else {
                // Hash the password using bcrypt. Insert the form html user in the db with the password hash
                $hash = password_hash($_POST['password'], PASSWORD_BCRYPT); 
                $this->_db->insert_members($_POST['username'],$_POST['email'],$hash);
                $_SESSION['user_id'] = $_POST['email'];
                header("Location: index.php");
                die();
            }
        }
		
		require_once(VIEWS_PATH . 'signin.php');
	}
	
} 
?>