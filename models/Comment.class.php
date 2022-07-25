<?php
class Comment{
	
	private int $id_comments;
	private string $text;
	private ?DateTimeImmutable $date_submitted;
	private bool $deleted;
	private int $id_member;
	private int $id_idea;
	private string $username;
	private string $idea_title;

	public function __construct($id_comments, $text, $date_submitted, $deleted, $id_member, $id_idea, $username="", $idea_title=""){
		$this->_id_comments = $id_comments;
		$this->_text = $text;
		$this->_date_submitted = new DateTimeImmutable($date_submitted);
		$this->_deleted = $deleted;
		$this->_id_member = $id_member;
		$this->_id_idea = $id_idea;
		$this->_username = $username;
		$this->_idea_title = $idea_title;
	}
	
	public function id_comments(){
		return $this->_id_comments;
	}

	public function text(){
		return $this->_text;
	}
	
	public function date_submitted(){
		return $this->date_submitted;
	}

	public function deleted(){
		return $this->deleted;
	}

	public function id_member(){
		return $this->_id_member;
	}

	public function _id_idea(){
		return $this->id_idea;
	}

	public function _username(){
		return $this->username;
	}

	public function _idea_title(){
		return $this->idea_title;
	}
	
	public function html_id_comments(){
		return htmlspecialchars($this->_id_comments);
	}

	public function html_text(){
		return htmlspecialchars($this->_text);
	}
	
	public function html_date_submitted(){
		return htmlspecialchars($this->_date_submitted);
	}

	public function html_deleted(){
		return htmlspecialchars($this->_deleted);
	}

	public function html_id_member(){
		return htmlspecialchars($this->_id_member);
	}

	public function html_id_idea(){
		return htmlspecialchars($this->_id_idea);
	}

	public function html_username(){
		return htmlspecialchars($this->_username);
	}

	public function html_idea_title(){
		return htmlspecialchars($this->_idea_title);
	}
}
?>