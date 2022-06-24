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
            $cfg=parent::cfg();
            $data=[
                'user'=>$user,
                'isAuth'=>$this->isAuth(),
                'siteUrl'=>$cfg['siteUrl']
            ];
            parent::view('user', $data);
        } else {
            $data=[
                'error'=>[
                    '404'
                ]
            ];
            parent::view('error', $data);
        }
    }
    public function isAuth()
    {
        $where['id']=@$_COOKIE['userId'];
        $where['token']=@$_COOKIE['userToken'];
        $where=['AND'=>$where];
        $UserModel=new UserModel();
        $cols=[
            'id',
            'name',
            'username',
            'token_expiration'
        ];
        $user=$UserModel->read($where, $cols);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    public function logout()
    {
        $tokenExpiration=$_GET['tokenExpiration'];
        $where['id']=@$_COOKIE['userId'];
        $where['token']=@$_COOKIE['userToken'];
        $where['token_expiration']=$tokenExpiration;
        $where=['AND'=>$where];
        $UserModel=new UserModel();
        $cols=[
            'id',
            'token_expiration'
        ];
        $user=$UserModel->read($where, $cols);
        if ($user['token_expiration']==$tokenExpiration) {
            $expiration=1;
            setcookie(
                "userId",
                null,
                $expiration
            );
            setcookie(
                "userToken",
                null,
                $expiration
            );
        }
        $cfg=parent::cfg();
        $url=$cfg['siteUrl'];
        parent::redirect($url);
    }
}
