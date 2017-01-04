<?php

namespace Orm\Controllers;

use Illuminate\Database\MySqlConnection;
use PDO;

class Db extends Connection
{
    private $pdo;
    private $db;

    public function __construct($params)
    {
        $this->setPdo(
            $params['host'], $params['database'], $params['user'], $params['password']
        );
        $this->setDb(new MySqlConnection($this->pdo));
    }

    /**
     * @return MySqlConnection
     */
    public function getDb()
    {
        return $this->db;
    }

    protected function setDb(MySqlConnection $db)
    {
        $this->db = $db;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    protected function setPdo()
    {
        list($host, $database, $user, $password) = func_get_args();
        $this->pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    }

    public function table($table)
    {
        return $this->getDb()->table($table);
    }
}
