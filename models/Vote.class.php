<?php
class Vote{
	
	private int $_id_member;
	private int $_id_idea;
	private string $_title;
	private string $_member;

	public function __construct($id_member, $id_idea, $title="", $member=""){
		$this->_id_member = $id_member;
		$this->_id_idea = $id_idea;
		$this->_title = $title;
		$this->_member = $member;
	}
	
	public function id_member(){
		return $this->_id_member;
	}

	public function id_idea(){
		return $this->_id_idea;
	}

	public function title(){
		return $this->_title;
	}

	public function member(){
		return $this->_member;
	}

	public function html_id_member(){
		return htmlspecialchars($this->_id_member);
	}

	public function html_id_idea(){
		return htmlspecialchars($this->_id_idea);
	}

	public function html_title(){
		return htmlspecialchars($this->_title);
	}

	public function html_member(){
		return htmlspecialchars($this->_member);
	}
}
?>