<?php

namespace Orm\Controllers\Queries;

use Orm\Controllers\Drivers\RedisDriver;
use Predis\Client;

class RedisQuery
{
    /**
     * 底层驱动实例
     *
     * @var Client
     */
    private $db;

    /**
     * 表名
     *
     * @var
     */
    private $table_name;

    public function __construct($instance)
    {
        /**
         * 连接底层驱动
         */
        $driver = new RedisDriver($instance);
        $this->db = $driver->getConnection();
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }

    public function get($params)
    {
        $this->table_name = $params['this']->table;

        $rows = $this->db->smembers($this->table_name);

        foreach ($rows as &$id) {
            $id = $this->sFind($id);
        }

        return $rows;
    }

    public function find($params)
    {
        $this->table_name = $params['this']->table;

        return $this->sFind($params[0]);
    }

    //todo
    public function where($params)
    {
        $this->table_name = $params['this']->table;

        return $this->sFind($params[0]);
    }

    private function sFind($key)
    {
        return json_decode($this->db->get($this->table_name . '/' . $key));
    }

    public function save($params)
    {
        $this->table_name = $params['this']->table;

        $tmps = [];
        foreach ($params['this'] as $k => $v) {
            if (in_array($k, ['table', 'primary_key', 'foreign_key', 'driver'])) {
                continue;
            }
            $tmps[$k] = $v;
        }

        $this->db->set($this->table_name . '/' . $tmps['id'], json_encode($tmps));
        $this->db->sadd($this->table_name, $tmps['id']);
    }
}
