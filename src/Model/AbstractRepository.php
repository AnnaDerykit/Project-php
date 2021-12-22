<?php
namespace App\Model;

use PDO;

abstract class AbstractRepository
{
    protected $pdo;
    public function __construct() {
        global $config;
        try {
            $this->pdo = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        catch (\PDOException $e) {
            echo "PDOException was caught: {$e->getMessage()}.<br/>\n";
            var_dump($e->getTraceAsString());
        }
    }
}