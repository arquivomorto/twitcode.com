<?php

namespace app\model;

use app\lib\Utils;

class UserModel extends Utils
{
    public $db;
    public function __construct()
    {
        $this->db=parent::db();
    }
    public function create($user)
    {
        $result=$this->db->insert('users', $user);
        return $this->db->id();
    }
    public function emailExists($email)
    {
        $where=[
            'email'=>$email
        ];
        return $this->db->has('users', $where);
    }
}
