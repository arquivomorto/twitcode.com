<?php

namespace app\lib;

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
