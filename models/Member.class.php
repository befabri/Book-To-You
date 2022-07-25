<?php
class Member{
	
	private int $_id_member;
	private string $_username;
	private string $_email;
	private string $_password;
	private bool $_active;
	private string $_privilege;

	public function __construct($id_member, $username, $email, $password, $active, $privilege){
		$this->_id_member = $id_member;
		$this->_username = $username;
		$this->_email = $email;
		$this->_password = $password;
		$this->_active = $active;
		$this->_privilege = $privilege;
	}
	
	public function id_member(){
		return $this->_id_member;
	}

	public function username(){
		return $this->_username;
	}
	
	public function email(){
		return $this->_email;
	}

	public function password(){
		return $this->_password;
	}

	public function active(){
		return $this->_active;
	}

	public function privilege(){
		return $this->_privilege;
	}

	public function html_id_member(){
		return htmlspecialchars($this->_id_member);
	}

	public function html_username(){
		return htmlspecialchars($this->_username);
	}
	
	public function html_email(){
		return htmlspecialchars($this->_email);
	}

	public function html_password(){
		return htmlspecialchars($this->_password);
	}

	public function html_active(){
		return htmlspecialchars($this->_active);
	}

	public function html_privilege(){
		return htmlspecialchars($this->_privilege);
	}

	public function is_password_correct($password){
		return password_verify($password, $this->password());
	}

	public function is_admin(){
		return $this->privilege() == "admin";
	}

	public function is_remove(){
		return $this->active() == 0;
	}
}
?>