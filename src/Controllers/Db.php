<?php

namespace Orm\Controllers;

use Illuminate\Database\MySqlConnection;
use PDO;

class DbController
{
    private $pdo;
    private $db;

    public function __construct()
    {
        list($host, $database, $user, $password) = func_get_args();
        $this->setPdo($host, $database, $user, $password);
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
