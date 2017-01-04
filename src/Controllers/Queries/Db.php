<?php

namespace Orm\Controllers\Queries;

use Orm\Commons\Row;
use Orm\Exceptions\NotFoundException;
use Illuminate\Support\Collection;
use stdClass;
use Orm\Controllers\Drivers\Db as Driver;

class Db implements QueryInterface
{
    protected $query;

    /**
     * 驱动配置
     *
     * @var
     */
    public static $config;

    public static $table;

    public static $primary_key;

    public function __construct()
    {
        /**
         * 连接底层驱动
         */
        $db = new Driver(static::$config);

        $this->query = $db->table(static::$table);
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

    /**
     * @description
     * @return Collection|Row
     * @throws NotFoundException
     * @author Zhou Yu
     */
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
     * @param $params
     * @return $this
     * @author Zhou Yu
     */
    public function where($params)
    {
        list($a, $b, $c) = array_fill_to($params, 3);
        $this->query = $this->query->where($a, $b, $c);
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

    /**
     * @description
     * @param $array
     * @return Collection|Row
     * @author Zhou Yu
     */
    private function collect($array)
    {
        if ($array instanceof Collection) {
            return $array;
        }

        if ($array instanceof stdClass) {
            return $this->addSave($array);
        }

        if (is_array($array)) {
            foreach ($array as &$item) {
                $this->addSave($item);
            }
            return $array;
        }

        return new Collection($array);
    }

    /**
     * @description 为每个 stdClass 添加 save 方法
     * @param $item
     * @return Row
     * @author Zhou Yu
     */
    private function addSave(&$item)
    {
        $item = new Row($item);
        $item->save = function () use ($item) {
            $item = array_del((array) $item, 'save');

            $class = $this->getNewThis();
            return $class->where([static::$primary_key, $item[static::$primary_key]])
                ->update(array_del($item, static::$primary_key));
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
}
