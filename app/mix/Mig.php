<?php
namespace app\mix;

use Pdo;

class Mig
{
    var $conn, $tableDirectory, $dbType;

    function __construct($conn, $tableDirectory, $dbType)
    {
        $this->conn = $conn;
        $this->tableDirectory = $tableDirectory;
        $this->dbType = $dbType;
    }

    function createColumn($columnName, $tableName)
    {
        $tableColumns = $this->getTableColumns($tableName);
        if (in_array($columnName, $tableColumns)) {
            return true;
        } else {
            switch ($this->dbType) {
                case 'mysql':
                    if ($columnName == 'id') {
                        $sufix = 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT';
                    } else {
                        $sufix = 'LONGTEXT NULL';
                    }
                    $sql = 'ALTER TABLE `' . $tableName . '` ADD `';
                    $sql .= $columnName . '` ' . $sufix . '; ';
                    break;
                case 'sqlite':
                    if ($columnName == 'id') {
                        $sufix = 'INTEGER PRIMARY KEY AUTOINCREMENT';
                    } else {
                        $sufix = 'TEXT';
                    }
                    $sql = 'ALTER TABLE `' . $tableName . '` ADD COLUMN `';
                    $sql .= $columnName . '` ' . $sufix . ';';
                    break;
            }
            return $this->query($sql);
        }
    }

    function createTable($tableName, $columnNames)
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $tableName . '` (' . PHP_EOL;
        switch ($this->dbType) {
            case 'mysql';
                $sql = $sql;
                $id = 'bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,' . PHP_EOL;
                $id .= chr(9) . 'PRIMARY KEY (id)';
                $text = 'LONGTEXT NULL';
                $sufix = ' ENGINE=InnoDB;';
                break;
            case 'sqlite';
                $id = 'INTEGER PRIMARY KEY AUTOINCREMENT';
                $text = 'TEXT';
                $sufix = ';';
                break;
        }
        $end = end($columnNames);
        foreach ($columnNames as $columnName) {
            if ($columnName == 'id') {
                $type = $id;
            } else {
                $type = $text;
            }
            $sql .= chr(9) . '`' . $columnName . '` ' . $type;
            $comma = null;
            if ($columnName != $end) {
                $comma = ',';
            }
            $sql .= $comma . PHP_EOL;
        }
        $sql .= ')' . $sufix;
        return $this->query($sql);
    }

    function dropColumn($columnName, $tableName)
    {
        switch ($this->dbType) {
            case 'mysql':
                $sql = 'ALTER TABLE `' . $tableName . '` DROP `' . $columnName . '`;';
                return $this->query($sql);
                break;
            case 'sqlite':
                $columnNames = $this->getTableColumns($tableName);
                $columnNames = array_flip($columnNames);
                unset($columnNames[$columnName]);
                $columnNames = array_flip($columnNames);
                $tmpTableName = 'mig_tmp_table';
                $this->createTable($tmpTableName, $columnNames);
                $columnNamesInline = '`' . implode('`,`', $columnNames) . '`';
                $sql = 'INSERT INTO ' . $tmpTableName . ' SELECT ';
                $sql .= $columnNamesInline . ' FROM `' . $tableName . '`;';
                $this->query($sql);
                $this->dropTable($tableName);
                $this->renameTable($tmpTableName, $tableName);
                return true;
                break;
        }
    }

    function dropTable($tableName)
    {
        $sql = 'DROP TABLE IF EXISTS `' . $tableName . '`;';
        return $this->query($sql);
    }

    function getMigrations()
    {
        $migrationsFiles = glob($this->tableDirectory . '/*');
        $migrations = [];
        foreach ($migrationsFiles as $filename) {
            $str = trim(file_get_contents($filename));
            $columnNames = array_map('trim', explode(PHP_EOL, $str));
            sort($columnNames);
            $migrationName = basename($filename);
            $migrations[$migrationName] = $columnNames;
        }
        return $migrations;
    }

    function getTableColumns($tableName)
    {
        switch ($this->dbType) {
            case 'mysql':
                $sql = 'SHOW COLUMNS FROM `' . $tableName . '`;';
                $column = 0;
                break;
            case 'sqlite':
                $sql = 'PRAGMA table_info(' . $tableName . ');';
                $column = 1;
                break;
        }
        $arr = $this->query($sql)->fetchAll(PDO::FETCH_COLUMN, $column);
        sort($arr);
        return $arr;
    }

    function getTableList()
    {
        switch ($this->dbType) {
            case 'mysql':
                $sql = 'SHOW TABLES;';
                break;
            case 'sqlite':
                $sql = 'SELECT name FROM sqlite_master WHERE type="table" AND
                name NOT LIKE "sqlite_%";';
                break;
        }
        $arr = $this->query($sql)->fetchAll(PDO::FETCH_COLUMN, 0);
        sort($arr);
        return $arr;
    }

    function getTables()
    {
        $tableList = $this->getTableList();
        $tables = [];
        foreach ($tableList as $tableName) {
            $tables[$tableName] = $this->getTableColumns($tableName);
        }
        return $tables;
    }

    function query($sql)
    {
        return $this->conn->query($sql);
    }

    function renameTable($oldTableName, $newTableName)
    {
        switch ($this->dbType) {
            case 'mysql':
                $sql = 'ALTER TABLE `' . $oldTableName . '` RENAME `' . $newTableName . '`';
                break;
            case 'sqlite':
                $sql = 'ALTER TABLE `' . $oldTableName . '` RENAME TO `' . $newTableName . '`';
                break;
        }
        return $this->query($sql);
    }

    function run()
    {
        $migrations = $this->getMigrations();
        $migrationsList = array_keys($migrations);
        $tables = $this->getTables();
        $tablesList = array_keys($tables);
        $tablesToDelete = array_diff($tablesList, $migrationsList);
        foreach ($tablesToDelete as $tableName) {
            $this->dropTable($tableName);
            unset($tables[$tableName]);
        }
        $tablesToCreate = array_diff($migrationsList, $tablesList);
        foreach ($tablesToCreate as $tableName) {
            $columnNames = $migrations[$tableName];
            $this->createTable($tableName, $columnNames);
            unset($migrations[$tableName]);
        }
        foreach ($tables as $tableName => $tableColumns) {
            $migrationColumns = $migrations[$tableName];
            $columnsToDelete = array_diff($tableColumns, $migrationColumns);
            foreach ($columnsToDelete as $columnName) {
                $this->dropColumn($columnName, $tableName);
            }
            $columnsToCreate = array_diff($migrationColumns, $tableColumns);
            foreach ($columnsToCreate as $columnName) {
                $this->createColumn($columnName, $tableName);
            }
        }
        return true;
    }
}
