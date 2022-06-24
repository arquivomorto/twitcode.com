<?php

namespace app\controller;

use app\lib\Utils;
use app\model\UserModel;

class UserController extends Utils
{
    public function create($email, $name, $password)
    {
        $user=[
            'name'=>$name,
            'email'=>$email,
            'password'=>password_hash($password, PASSWORD_DEFAULT),
            'status'=>'unconfirmed',
            'created_at'=>time(),
            'confirmation_code'=>parent::random()
        ];
        $UserModel=new UserModel();
        $userId=$UserModel->create($user);
        if (is_numeric($userId)) {
            $username='user'.$userId;
            $data=[
                'username'=>$username
            ];
            $where=[
                'id'=>$userId
            ];
            $UserModel->update($data,$where);
            $user['id']=$userId;
            return $user;
        } else {
            return false;
        }
    }
    public function get()
    {
        $userId=$_GET['id'];
        $UserModel=new UserModel();
        $where=[
            'id'=>$userId
        ];
        $cols=[
            'id',
            'name',
            'username',
            'site',
            'github',
            'linkedin',
            'instagram',
            'twitter',
            'bio'
        ];
        $user=$UserModel->read($where, $cols);
        if ($user) {
            $data=[
                'user'=>$user
            ];
            parent::view('user', $data);
        }else{
            $data=[
                'error'=>[
                    '404'
                ]
            ];
            parent::view('error', $data);
        }
    }
}
