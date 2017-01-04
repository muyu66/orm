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
    protected $table;

    /**
     * 自增主键
     *
     * @var string
     */
    public $primary_key = 'id';

    /**
     * 分发之后的驱动
     *
     * @var null|Queries\Db|Queries\Redis
     */
    private $driver;

    public function __construct()
    {
        $config = getConfig();

        $driver = new Connection();

        $this->driver = $driver->dispatch($config, $this->table, $this->primary_key);
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
