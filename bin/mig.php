<?php

require 'vendor/autoload.php';

use app\lib\DB;
use app\lib\Mig;
use app\lib\Utils;

$Utils=new Utils();
$cfg=$Utils->cfg();
$Utils->showErrors($cfg['showErrors']);
$db=$Utils->db();
$tableDirectory = $cfg['root'] . '/table';
$dbType = $cfg['dbDefault'];
$mig = new Mig($db->pdo, $tableDirectory, $dbType);
system("clear");
print 'executando migrations...' . PHP_EOL;
if ($mig->run()) {
    print 'migrations executadas com sucesso =)' . PHP_EOL;
}
