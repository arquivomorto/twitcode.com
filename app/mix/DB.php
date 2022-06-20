<?php

namespace app\mix;

use app\mix\Utils;

use Pdo;
use PDOException;

class DB extends Utils
{
    public $pdoDsn;
    public $pdoUsername;
    public $pdoPassword;
    public function conn($name)
    {
        $cfg=parent::cfg()['db'][$name];
        switch ($name) {
            case 'mysql':
                $pdoDb = $cfg['db'];
                    $pdoHost = $cfg['host'];
                    $this->pdoPassword = $cfg['password'];
                    $this->pdoUsername = $cfg['user'];
                    $this->pdoDsn = "mysql:host=$pdoHost;dbname=$pdoDb";
                    break;
                case 'sqlite':
                    $pdoDsn = "sqlite:" . $cfg['file'];
                    break;
        }
        try {
            $conn = new PDO($this->pdoDsn, $this->pdoUsername, $this->pdoPassword);
        } catch (PDOException $e) {
            print "Erro ao conectar: " . PHP_EOL . $e->getMessage();
        }
        return $conn;
    }
}
