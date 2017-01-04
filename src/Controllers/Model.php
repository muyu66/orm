<?php

namespace Orm\Controllers;

use Orm\Controllers\Connections\Connection;

class Model
{
    /**
     * 表名
     *
     * @var string
     */
    public $table;

    /**
     * 自增主键
     *
     * @var string
     */
    public $primary_key = 'id';

    /**
     * 默认外键，例如 user_id
     *
     * @var string
     */
    public $foreign_key;

    /**
     * 分发之后的驱动
     *
     * @var null|Queries\Db|Queries\Redis
     */
    private $driver;

    public function __construct()
    {
        $config = get_config();

        $driver = new Connection();

        $this->driver = $driver->dispatch($config, $this->table, $this->primary_key);

        $this->foreign_key = strtolower(get_class_name(static::class)) . '_id';
    }

    public function hasMany($class, $foreign_key = null, $local_key = null)
    {
        $foreign_key = $foreign_key ? : $this->foreign_key;
        $local_key = $local_key ? : $this->primary_key;

        return $this->driver->with($class, $foreign_key, $local_key);
    }

    /**
     * @description 分发驱动的方法, 比如 get(), update()
     * @param $method
     * @param $params
     * @return string
     * @author Zhou Yu
     */
    public function __call($method, $params)
    {
        if ($this->driver) {
            return $this->driver->$method($params);
        }
        return 'not found this method';
    }
}
