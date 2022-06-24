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
            $user['id']=$userId;
            return $user;
        } else {
            return false;
        }
    }
}
