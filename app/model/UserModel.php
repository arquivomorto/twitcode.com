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
    public function read($where, $cols=null)
    {
        if (is_null($cols)) {
            $cols='*';
        }
        return $this->db->get('users', $cols, $where);
    }
    public function update($data, $where)
    {
        return $this->db->update('users', $data, $where);
    }
}
