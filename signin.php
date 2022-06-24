<?php

require 'vendor/autoload.php';
$cfg=require 'cfg.php';

use app\lib\Utils;
use app\controller\SigninController;

$Utils=new Utils();
$Utils->showErrors($cfg['showErrors']);

if($Utils->method()=='POST'){
    $SigninController=new SigninController();
    $SigninController->post();
}