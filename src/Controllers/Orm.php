<?php

namespace Orm\Controllers;

use Orm\Controllers\Connections\Connection;
use Orm\Controllers\Queries\RedisQuery;

class Orm
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
     * 获取驱动实例
     *
     * @var RedisQuery|null
     */
    private $driver;

    public function __construct()
    {
        $this->driver = Connection::get();

        $this->foreign_key = strtolower(get_class_name(static::class)) . '_id';
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
        $params['this'] = $this;

        if ($this->driver) {
            return $this->driver->$method($params);
        }
        return 'not found this method';
    }
}
