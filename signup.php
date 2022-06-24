<?php

require 'vendor/autoload.php';
$cfg=require 'cfg.php';

use app\lib\Utils;
use app\controller\SignupController;

$Utils=new Utils();
$Utils->showErrors($cfg['showErrors']);

if($Utils->method()=='POST'){
    $SignupController=new SignupController();
    $SignupController->post();
}