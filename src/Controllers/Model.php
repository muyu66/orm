<?php

namespace Orm\Controllers;

use Orm\Commons\Row;
use Orm\Exceptions\NotFoundException;
use Illuminate\Support\Collection;
use stdClass;

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
     * 数据库驱动
     *
     * @var
     */
    protected $driver;

    private $db;
    private $query;

    public function __construct()
    {
        $config = getConfig();
        $this->setDriver($config['driver']);
        $this->db = $this->getDriver($config);
        $this->query = $this->getDb()->table($this->table);
    }

    private function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @description
     * @param $params
     * @return Db|Redis
     * @author Zhou Yu
     */
    private function getDriver($params)
    {
        $class = 'Orm\\Controllers\\' . $this->driver;
        return new $class($params);
    }

    private function getDb()
    {
        return $this->db;
    }

    /**
     * @description
     * @param $array
     * @return Collection|Row|array
     * @author Zhou Yu
     */
    private function collect($array)
    {
        if ($array instanceof Collection) {
            return $array;
        }

        if ($array instanceof stdClass) {
            return $this->save($array);
        }

        if (is_array($array)) {
            foreach ($array as &$item) {
                $this->save($item);
            }
            return $array;
        }

        return new Collection($array);
    }

    /**
     * @description
     * @param $item
     * @return Row
     * @author Zhou Yu
     */
    private function save(&$item)
    {
        $item = new Row($item);
        $item->save = function () use ($item) {
            $item = array_del((array) $item, 'save');

            $models = $this->getNewThis();
            $primary_key = $models->primary_key;

            return $models->where($primary_key, $item[$primary_key])
                ->update(array_del($item, $primary_key));
        };
        return $item;
    }

    /**
     * @description
     * @return $this
     * @author Zhou Yu
     */
    private function getNewThis()
    {
        return new $this;
    }

    /**
     * @description
     * @return array|Collection|Row
     * @author Zhou Yu
     */
    public function get()
    {
        $data = $this->query->get();
        return $this->collect($data);
    }

    /**
     * @description
     * @return Collection|Row
     * @author Zhou Yu
     */
    public function first()
    {
        $data = $this->query->first();
        return $this->collect($data);
    }

    public function firstOrFail()
    {
        $data = $this->query->first();
        if (is_null($data)) {
            throw new NotFoundException();
        }
        return $this->collect($data);
    }

    /**
     * @description
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     * @author Zhou Yu
     */
    public function where($column, $operator = null, $value = null)
    {
        $this->query = $this->query->where($column, $operator, $value);
        return $this;
    }

    /**
     * @description
     * @param $array
     * @return int 所影响行数
     * @author Zhou Yu
     */
    public function update($array)
    {
        return $this->query->update($array);
    }
}
