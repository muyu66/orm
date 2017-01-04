<?php

namespace Orm\Controllers\Connections;

use Orm\Controllers\Queries\Db;
use Orm\Controllers\Queries\Redis;

class Connection
{
    public function dispatch($config, $table, $primary_key)
    {
        switch ($config['driver']) {
            case 'mysql':
                Db::$config = $config;
                Db::$table = $table;
                Db::$primary_key = $primary_key;
                return new Db();
            case 'redis':
                return new Redis();
            default:
                return null;
        }
    }
}
