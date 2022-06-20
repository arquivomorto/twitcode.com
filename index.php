<?php

require 'vendor/autoload.php';
$cfg=require 'cfg.php';

use app\controller\Home;
use app\mix\Utils;

$Utils=new Utils();
$Utils->showErrors($cfg['showErrors']);

$Home=new Home();
$Home->index();
