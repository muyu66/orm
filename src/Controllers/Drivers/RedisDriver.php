<?php

namespace Orm\Controllers\Drivers;

class RedisDriver extends Driver
{
    public function __construct($redis)
    {
        $this->setConnection($redis);
    }
}
