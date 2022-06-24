<?php

require 'vendor/autoload.php';
$cfg=require 'cfg.php';

use app\lib\Utils;
use app\controller\UserController;

$Utils=new Utils();
$Utils->showErrors($cfg['showErrors']);

$UserController=new UserController();
$UserController->logout();