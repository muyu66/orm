<?php

namespace Orm\Controllers\Drivers;

use Illuminate\Database\MySqlConnection;
use PDO;

class Db extends Driver
{
    private $pdo;

    public function __construct($params)
    {
        $this->setPdo(
            $params['host'], $params['database'], $params['username'], $params['password']
        );
        $this->setConnection(new MySqlConnection($this->getPdo()));
    }

    /**
     * @return MySqlConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    private function getPdo()
    {
        return $this->pdo;
    }

    private function setPdo()
    {
        list($host, $database, $user, $password) = func_get_args();
        $this->pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    }

    public function table($table)
    {
        return $this->getConnection()->table($table);
    }
}
