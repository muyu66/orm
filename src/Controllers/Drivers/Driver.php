<?php

namespace Orm\Controllers\Drivers;

class Driver implements DriverInterface
{
    protected $connection;

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
