<?php

class UserModel {

    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByUsername($username)
    {
        $this->db->query('SELECT * FROM '. $this->table .' WHERE username=:username');
        $this->db->bind('username', $username);

        return $this->db->single();
    }
}