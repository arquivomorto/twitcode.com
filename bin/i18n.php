<?php

require 'vendor/autoload.php';

use app\lib\I18n;

$i18n=new I18n();
$i18n->criarTraduções();
exit('pronto!'.PHP_EOL);
