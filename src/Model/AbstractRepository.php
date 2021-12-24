<?php
namespace App\Model;

use PDO;

abstract class AbstractRepository
{
    /**
     * @var
     */
    protected $connection;

    /**
     * @return void
     */
    protected function openDatabaseConnection() {
        global $config;
        try {
            $this->connection = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        catch (\PDOException $e) {
            echo "PDOException was caught: {$e->getMessage()}";
            var_dump($e->getTraceAsString());
        }
    }

    /**
     * @return void
     */
    protected function closeDatabaseConnection() {
        $this->connection = null;
    }

    /**
     * @param $object
     * @return mixed
     */
    abstract public function save($object);
}