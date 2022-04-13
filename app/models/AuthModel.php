<?php

class AuthModel {

    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function register($data)
    {
        $query = "INSERT INTO ". $this->table ." (username, password) VALUES (:username, :password)";
        $this->db->query($query);

        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM '. $this->table .' WHERE username=:username');
        $this->db->bind('username', $username);

        $row = $this->db->single();
        $hashPassword = $row['password'];

        if (password_verify($password, $hashPassword)) {
            return $row;
        } else {
            return false;
        }
    }
    
}