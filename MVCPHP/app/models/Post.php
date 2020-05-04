<?php


class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    public function getPosts(){
        $this->db->query("SELECT *,
                                    posts.id as postId,
                                    users.user_id as userId,
                                    posts.create_at as postCreated,
                                    users.created_at as userCreated
                                        FROM posts 
                                        INNER JOIN users 
                                        ON posts.user_id = users.user_id
                                        ORDER BY posts.create_at DESC 
                                        
                                        ");
        $result =  $this->db->resultSet();
        return $result;
    }

    public function addPost($data){
        $this->db->query('INSERT INTO posts (title,user_id,body) VALUES(:title ,:user_id,:body) ');
        //bind value
        $this->db->bind(':title',$data['title']);
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':body',$data['body']);
        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function getPostById($id){
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }
}

