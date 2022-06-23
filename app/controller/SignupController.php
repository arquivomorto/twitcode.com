<?php

namespace app\controller;

use app\model\UserModel;
use app\lib\Utils;

class SignupController extends Utils
{
    public $error=[];
    public function post()
    {
        // validar o email
        $email=$_POST['email'];
        $email=trim($email);
        $email=mb_strtolower($email);
        $email=$this->validEmail($email);

        // validar o nome
        $name=$_POST['name'];
        $name=$this->validName($name);

        // validar a senha
        $password=$_POST['password'];
        $password=$this->validPassword($password);

        if ($email and $name and $password) {
            $user=[
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
                'status'=>'unconfirmed',
                'created_at'=>time(),
                'confirmation_code'=>parent::random()
            ];
            // criar usuário
            $UserModel=new UserModel();
            $userId=$UserModel->create($user);
            // enviar email de confirmação
            // logar
            $SigninController=new SigninController();
            $SigninController->usingEmailAndPassword($email, $password);
            // redirecionar pra tela de usuário
            $url='/user.php?id='.$userId;
            parent::redirect($url);
        } else {
            // mensagem de erro
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
    public function validEmail($email)
    {
        $email=mb_strtolower($email);
        $UserModel=new UserModel();
        $emailExists=$UserModel->emailExists($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) and !$emailExists) {
            return $email;
        } else {
            $this->setError('invalidEmail');
            return false;
        }
    }
    public function validName($name)
    {
        $arr=explode(' ', $name);
        $arr=array_map('trim', $arr);
        $arr=array_values($arr);
        $validName=implode(' ', $arr);
        foreach ($arr as $key=>$value) {
            if (!ctype_graph($value)) {
                $this->setError('invalidName');
                $validName=false;
                break;
            }
        }
        return $validName;
    }
    public function validPassword($password)
    {
        $min=8;
        $max=256;
        $len=mb_strlen($password);
        if ($len>=$min and $len<=$max) {
            return password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->setError('invalidPassword');
            return false;
        }
    }
}
