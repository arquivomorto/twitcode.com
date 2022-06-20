<?php

require 'vendor/autoload.php';

use app\mix\DB;
use app\mix\Mig;
use app\mix\Utils;

$utils=new Utils();
$cfg=$utils->cfg();
$utils->showErrors($cfg['showErrors']);

$db=new DB();
$conn=$db->conn($cfg['dbDefault']);
$tableDirectory = $cfg['root'] . '/table';
$dbType = $cfg['dbDefault'];
$mig = new Mig($conn, $tableDirectory, $dbType);
system("clear");
print 'executando migrations...' . PHP_EOL;
if ($mig->run()) {
    print 'migrations executadas com sucesso =)' . PHP_EOL;
}
