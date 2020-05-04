<?php


class User
{
    private $db;
    public function __construct()
    {
      $this->db =  new Database();
    }
    // Register User

    public function register($data){
        //add user
        $this->db->query('INSERT INTO users (name,email,password) VALUES(:name ,:email,:password) ');
        //bind value
        $this->db->bind(':name',$data['name']);
        $this->db->bind('email',$data['email']);
        $this->db->bind('password',$data['password']);
        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function login($email,$password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email',$email);
        $row = $this->db->single();
        $hassed_password = $row->password;
        if(password_verify($password,$hassed_password)){
            return $row;
        }else{
            return false;
        }
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');

        $this->db->bind(':email',$email);


        $row = $this->db->single();
        //check row

        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getUserById($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');

        $this->db->bind(':id',$id);


        $row = $this->db->single();

        return $row;
    }

}