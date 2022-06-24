<?php

namespace app\controller;

use app\controller\UserController;
use app\lib\Utils;
use app\model\UserModel;

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
            // criar usuário
            $UserController=new UserController();
            $user=$UserController->create($email, $name, $password);
            if ($user) {
                // enviar email de confirmação
                // logar
                $SigninController=new SigninController();
                $SigninController->usingEmailAndPassword($email, $password);
                // redirecionar pra tela de usuário
                $url='/user.php?id='.$user['id'];
                parent::redirect($url);
            } else {
                $this->setError('unknownError');
            }
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
            return $password;
        } else {
            $this->setError('invalidPassword');
            return false;
        }
    }
    public function __destruct()
    {
        if (count($this->error)>=1) {
            $data=[
                'error'=>$this->error
            ];
            parent::view('error', $data);
        }
    }
}
