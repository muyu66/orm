<?php

namespace Orm\Controllers\Connections;

use Orm\Controllers\Queries\RedisQuery;
use Predis\Client;

class Connection
{
    private static $instance = null;

    public function __construct($instance)
    {
        if ($instance instanceof Client) {
            self::$instance = new RedisQuery($instance);
        }
    }

    public static function get()
    {
        return self::$instance;
    }
}
