<?php
class Db
{
    private static $instance = null;
    private $_connection;

    private function __construct()
    {
        try {
            $this->_connection = new PDO('mysql:host=localhost;dbname=booktoyou;charset=utf8', getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

	# Singleton Pattern
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    /* =====================================================================
                                        IDEA
       ===================================================================== */
    
    public function select_ideas($id_idea) {
        $query = 'SELECT * FROM ideas WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        $row = $ps->fetch();
        if ($ps->rowcount() == 0)
            return null;
        return new Idea($row->id_idea, $row->title, $row->text, $row->status, $row->date_submitted, $row->date_accepted, $row->date_refused, $row->date_closed, $row->id_member);
    }

    public function select_ideas_all($limit="",$sort="vote", $order="desc", $submitted="",$accepted="",$refused="",$closed="") {
        $sorts = array("date"=>"ideas.date_submitted", "vote"=>"votes_count", "id"=>"id_idea", "status"=>"status", "title"=>"title");
        if (!array_key_exists($sort, $sorts))
            $sort="vote";
        if (strtolower($order) != "asc" && strtolower($order) != "desc" )
            $order="desc";
        $queryWhereStatus = "";
        $sort = $sorts[$sort];
        if ($submitted || $accepted || $refused || $closed) 
            $queryWhereStatus =  "WHERE ideas.status IN ('{$submitted}', '{$accepted}', '{$refused}', '{$closed}')";
        $query = 'SELECT
                        ideas.id_idea, ideas.title, ideas.text, ideas.status, ideas.date_submitted, ideas.date_accepted, ideas.date_refused, ideas.date_closed, ideas.id_member,
                        COUNT(votes.id_idea) AS votes_count
                    FROM
                        ideas
                    LEFT JOIN votes ON votes.id_idea = ideas.id_idea
                    '.$queryWhereStatus.'
                    GROUP BY ideas.id_idea
                    ORDER BY '.$sort.' '.$order;
        if($limit){
            $query .= ' LIMIT :limit';
        }
        $ps = $this->_connection->prepare($query);
        if($limit){
            $ps->bindValue(':limit',$limit,PDO::PARAM_INT);
        }
        $ps->execute();
        $table = array();
        while ($row = $ps->fetch()) {
            $comment = $this->count_comments($row->id_idea);
            $table[] = new Idea($row->id_idea, $row->title, $row->text, $row->status, $row->date_submitted, $row->date_accepted, $row->date_refused,
                            $row->date_closed, $row->id_member, $row->votes_count, $comment);
        }
        return $table;
    }

    public function select_ideas_all_by_member($id_member) {
        // Select all idea of a member 
        $query = 'SELECT
                        ideas.id_idea, ideas.title, ideas.text, ideas.status, ideas.date_submitted, ideas.date_accepted, ideas.date_refused, ideas.date_closed, ideas.id_member,
                        COUNT(votes.id_idea) AS votes_count
                    FROM
                        ideas
                    LEFT JOIN votes ON votes.id_idea = ideas.id_idea
                    WHERE ideas.id_member=:id_member
                    GROUP BY ideas.id_idea
                    ORDER BY votes_count DESC';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        $table = array();
        while ($row = $ps->fetch()) {
            $comment = $this->count_comments($row->id_idea);
            $table[] = new Idea($row->id_idea, $row->title, $row->text, $row->status, $row->date_submitted, $row->date_accepted, $row->date_refused,
                            $row->date_closed, $row->id_member, $row->votes_count, $comment);
        }
        return $table;
    }

    public function insert_ideas($title,$text,$status,$date_submitted,$id_member) { 
        $query = 'INSERT INTO ideas (title,text,status,date_submitted,id_member) values (:title,:text,:status,:date_submitted,:id_member)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':title',$title);
        $ps->bindValue(':text',$text);
        $ps->bindValue(':status',$status);
        $ps->bindValue(':date_submitted',$date_submitted);
        $ps->bindValue(':id_member',$id_member);
        return $ps->execute();
    }

    public function update_ideas_status($status,$id_idea,$datetime) {
        $dateStatus = array("submitted"=>"date_submitted", "accepted"=>"date_accepted", "refused"=>"date_refused","closed"=>"date_closed");
        $query = 'UPDATE ideas SET status=:status, '.$dateStatus[$status].'=:datetime WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':status',$status);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':datetime',$datetime);
        $ps->execute();
        return $ps->execute();
    }
    /* =====================================================================
                                        VOTES
       ===================================================================== */

     public function select_votes_all_by_member($id_member) {
        $query = 'SELECT v.id_member, v.id_idea, i.title, m.username
                    FROM votes v 
                    LEFT JOIN ideas i ON i.id_idea = v.id_idea 
                    LEFT JOIN members m ON i.id_member = m.id_member
                    WHERE v.id_member=:id_member 
                    ORDER BY i.id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        $table = array();
        while ($row = $ps->fetch()) {
            $table[] = new Vote($row->id_member, $row->id_idea, $row->title, $row->username);
        }
        return $table;
    }

    public function insert_votes($id_idea,$id_member) {
        $query = 'INSERT INTO votes (id_idea,id_member) values (:id_idea,:id_member)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':id_member',$id_member);
        return $ps->execute();
    }

    public function count_votes($id_idea) {
        $query = 'SELECT count(votes.id_idea) as votes_count FROM votes WHERE id_idea=:id_idea'; 
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        $row = $ps->fetch();
        if ($ps->rowcount() == 0)
            return null;
        return $row->votes_count;
    }

    public function exists_votes($id_idea,$id_member) {
        $query = 'SELECT * FROM votes WHERE id_idea=:id_idea AND id_member=:id_member';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    /* =====================================================================
                                        COMMENT
       ===================================================================== */

       // By default select all comments of a member id  
       // If it is not the id_member parameter, an id_idea parm must be passed
       public function select_comments_all($id_idea='',$id_member='') {
        if ($id_member!='') {
            $query = 'SELECT c.id_comments, c.text, c.date_submitted, c.deleted, c.id_member, c.id_idea, m.username, i.title
                        FROM comments c
                        LEFT JOIN members m ON c.id_member = m.id_member
                        LEFT JOIN ideas i ON i.id_idea = c.id_idea
                        WHERE c.id_member=:id_member
                        ORDER BY c.date_submitted';
            $ps = $this->_connection->prepare($query);
            $ps->bindValue(':id_member',$id_member);
        } elseif ($id_idea=='') {
            throw new \Exception('Le champs paramètre idée est vide');
        } else {
            $query = 'SELECT c.id_comments, c.text, c.date_submitted, c.deleted, c.id_member, c.id_idea, m.username
                        FROM comments c
                        LEFT JOIN members m ON c.id_member = m.id_member
                        WHERE c.id_idea = :id_idea
                        ORDER BY c.date_submitted';
            $ps = $this->_connection->prepare($query);
            $ps->bindValue(':id_idea',$id_idea);
        }
        $ps->execute();
        $table = array();
        while ($row = $ps->fetch()) {
            if ($id_member!='') {
                $table[] = new Comment($row->id_comments, $row->text, $row->date_submitted, $row->deleted, $row->id_member, $row->id_idea, $row->username, $row->title );
            } else {
                $table[] = new Comment($row->id_comments, $row->text, $row->date_submitted, $row->deleted, $row->id_member, $row->id_idea, $row->username);
            }
        }
        return $table;
    }

    public function count_comments($id_idea) {
        $query = 'SELECT COUNT(comments.id_idea) AS comments_count FROM comments WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        $row = $ps->fetch();
        if ($ps->rowcount() == 0)
            return null;
        return $row->comments_count;
    }

    public function insert_comments($text,$date_submitted,$id_member,$id_idea) { 
        $query = 'INSERT INTO comments (text,date_submitted,id_member,id_idea) values (:text,:date_submitted,:id_member,:id_idea)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':text',$text);
        $ps->bindValue(':date_submitted',$date_submitted);
        $ps->bindValue(':id_member',$id_member);
        $ps->bindValue(':id_idea',$id_idea);
        return $ps->execute();
    }

    public function exists_comments($id_comments,$id_member,$id_idea) { 
        $query = 'SELECT * FROM comments WHERE id_comments=:id_comments AND id_member=:id_member AND id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_comments',$id_comments);
        $ps->bindValue(':id_member',$id_member);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    public function remove_comments($id_comments) {
        $query = 'UPDATE comments SET deleted=1 WHERE id_comments=:id_comments';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_comments',$id_comments);
        return $ps->execute();
    }

    /* =====================================================================
                                        MEMBER
       ===================================================================== */

    public function select_members_by_email($email) {
        $query = 'SELECT * from members WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        $row = $ps->fetch();
        if ($ps->rowcount() == 0)
            return null;
        return new Member($row->id_member, $row->username, $row->email, $row->password, $row->active, $row->privilege);
    }

    public function select_members_all ($sort="id", $order="asc"){
        $sorts = array("active"=>"active", "email"=>"email", "id"=>"id_member", "role"=>"privilege", "username"=>"username");
        if (!array_key_exists($sort, $sorts))
            $sort = "id";
        if (strtolower($order) != "asc" && strtolower($order) != "desc" )
            $order="asc";
        $sort = $sorts[$sort];
        $query = 'SELECT * from members ORDER BY '.$sort.' '.$order;
        $ps = $this->_connection->prepare($query);
        $ps->execute(array($sort, $order));
        $table = [];
        while ($row = $ps->fetch()) {
            $table[] = new Member($row->id_member, $row->username, $row->email, $row->password, $row->active, $row->privilege);
        }
        return $table; 
    }

    public function insert_members($username,$email,$password) {
        $query = 'INSERT INTO members (username,email,password) values (:username,:email,:password)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':password',$password);
        return $ps->execute();
    }

    public function exists_username($username) {
        $query = 'SELECT * from members WHERE username=:username';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    // Update the active or privileged column of the members table
    public function update_members($column,$parameter,$id_member) {
        if ($column=="active") {
            $column="active";
        } elseif($column=="privilege") {
            $column="privilege";
        } else {
            return null;
        }
        $query = 'UPDATE members SET '.$column.'=:parameter WHERE id_member=:id_member';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':parameter',$parameter);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        return $ps->execute();
    }
    
}