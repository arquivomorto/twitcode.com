<?php

namespace app\lib;

use Medoo\Medoo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Utils
{
    public function asset($urls, $autoIndent = true)
    {
        if (is_string($urls)) {
            $arr[]=$urls;
            $urls=$arr;
        }
        foreach ($urls as $key => $url) {
            $cfg=$this->cfg();
            $root=$cfg['root'];
            $filename=$root.'/'.$url;
            $path_parts = pathinfo($url);
            $ext=$path_parts['extension'];
            if (file_exists($filename)) {
                $md5=md5_file($filename);
                $siteUrl=$cfg['siteUrl'];
                if (substr($siteUrl, -1) == '/') {
                    $url=$siteUrl.$url."?$md5";
                } else {
                    $url=$siteUrl.'/'.$url."?$md5";
                }
                if ($autoIndent and $key<>0) {
                    print '        ';
                }
                if ($ext=='css') {
                    print '<link rel="stylesheet" href="'.$url.'" />';
                }
                if ($ext=='js') {
                    print '<script type="text/javascript" src="'.$url.'"></script>';
                }
                print PHP_EOL;
            }
        }
    }
    public function cfg()
    {
        $filename=realpath(__DIR__.'/../../cfg.php');
        if (file_exists($filename)) {
            $arr=require $filename;
            return $arr;
        } else {
            die('cp cfg.example.php cfg.php');
        }
    }
    public function db($dbName='')
    {
        $cfg=$this->cfg();
        $dbDefault=$cfg['dbDefault'];
        if (empty($dbName)) {
            $dbCfg=$cfg['db'][$dbDefault];
        } else {
            $dbCfg=$cfg['db'][$dbName];
        }
        $opts=null;
        switch ($dbDefault) {
            case 'mysql':
                $opts=[
                    'type' => 'mysql',
                    'host' => $dbCfg['host'],
                    'database' => $dbCfg['db'],
                    'username' => $dbCfg['user'],
                    'password' => $dbCfg['password']
                ];
            break;
            case 'sqlite':
                $opts=[
                    'type' => 'sqlite',
                    'database' => $dbCfg['file']
                ];
            break;
            default:
                die('db not found');
            break;
        }
        return new Medoo($opts);
    }
    public function e($str, $print=true)
    {
        $out=null;
        if (is_string($str)) {
            $out=htmlentities($str);
        }
        if ($print) {
            print $out;
        } else {
            return $out;
        }
    }
    public function email($body, $subject, $to, $toName, $fromName = false, $fromMail = false)
    {
        $cfg=$this->cfg();
        $mailCfg=$cfg['email'][$cfg['emailDefault']];
        $mail=new PHPMailer();
        $mail->CharSet = 'UTF-8';
        if ($mailCfg['type']=='smtp') {
            $mail->IsSMTP();
        }
        if ($mailCfg['showErrors']) {
            $mail->SMTPDebug=1; // 1 = errors and messages, 2 = messages only
        } else {
            $mail->SMTPDebug=0;
        }
        if ($mailCfg['auth']) {
            $mail->SMTPAuth=true;
            $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Username=$mailCfg['user'];
            $mail->Password=$mailCfg['password'];
        } else {
            $mail->SMTPAuth=false;
        }
        if (!$fromName) {
            $fromName=$mailCfg['name'];
        }
        if (!$fromMail) {
            $fromMail=$mailCfg['from'];
        }
        $mail->Port=$mailCfg['port'];
        $mail->Host=$mailCfg['host'];
        $mail->SetFrom($fromMail, $fromName);
        $mail->AddReplyTo($fromMail, "Reply");
        $mail->Subject=$subject;
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $toName);
        return $mail->Send();
    }
    public function method($raw = false)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($raw) {
            return $method;
        } else {
            if ($method == 'POST') {
                return 'POST';
            } else {
                return 'GET';
            }
        }
    }
    public function random($tamanho=11)
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
        $randomStr = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $randomStr .= $str[rand(0, mb_strlen($str)-1)];
        }
        return $randomStr;
    }
    public function redirect($url)
    {
        header('Location: '.$url);
    }
    public function showErrors($bool)
    {
        if ($bool) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    }
    public function view($name, $data=[], $print=true)
    {
        $cfg=$this->cfg();
        $root=$cfg['root'];
        $filename=$root.'/app/view/'.$name.'.php';
        $asset=array($this, 'asset');
        $e=array($this, 'e');
        $siteUrl=$cfg['siteUrl'];
        $view=array($this, 'view');
        if (file_exists($filename)) {
            $data['data']=$data;
            extract($data);
            require '__.php';
            if ($print) {
                require $filename;
            } else {
                ob_start();
                require $filename;
                $output=ob_get_contents();
                ob_end_clean();
                return $output;
            }
        } else {
            $str='touch <b>'.$filename.'</b>';
            die($str);
        }
    }
}
