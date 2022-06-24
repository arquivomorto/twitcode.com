<?php

namespace app\controller;

use app\lib\Utils;
use app\model\UserModel;

class SigninController extends Utils
{
    public $error=[];
    public function post()
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $this->usingEmailAndPassword($email, $password);
    }
    public function usingEmailAndPassword($email, $password, $url='')
    {
        $UserModel=new UserModel();
        $email=mb_strtolower(trim($email));
        $user=$UserModel->emailExists($email);
        $passwordOk=false;
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $passwordOk=true;
            } else {
                $passwordOk=false;
                $this->setError('invalidPassword');
            }
        } else {
            $this->setError('invalidEmail');
        }
        if (count($this->error)==0) {
            $token=parent::random();
            $segundosPorDia=24*60*60;
            $segundosPorAno=365*$segundosPorDia;
            $segundosEmQuatroAnos=4*$segundosPorAno;
            $tokenExpiration=time()+$segundosEmQuatroAnos;
            $data=[
                'token'=>$token,
                'token_expiration'=>$tokenExpiration
            ];
            $where=[
                'id'=>$user['id']
            ];
            $UserModel->update($data, $where);
            if (
                setcookie('userId', $user['id'], $tokenExpiration) and
                setcookie('userToken', $token, $tokenExpiration)
            ) {
                if (empty($url)) {
                    $url='/user.php?id='.$user['id'];
                }
                parent::redirect($url);
            } else {
                $this->setError('unknownError');
            }
        } else {
            $data=[
                'error'=>$this->error
            ];
            parent::view('error', $data);
        }
    }
    public function setError($msgCode)
    {
        $this->error[]=$msgCode;
    }
}
