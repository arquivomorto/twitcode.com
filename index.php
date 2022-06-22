<?php

require 'vendor/autoload.php';
$cfg=require 'cfg.php';

use app\controller\HomeController;
use app\lib\Utils;

$Utils=new Utils();
$Utils->showErrors($cfg['showErrors']);

$Home=new HomeController();
$Home->index();
