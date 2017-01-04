<?php

namespace Orm\Controllers\Drivers;

interface DriverInterface
{
    public function setConnection($connection);

    public function getConnection();
}
