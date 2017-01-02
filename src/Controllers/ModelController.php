<?php

namespace Orm\Controllers;

use Illuminate\Support\Collection;
use Orm\Exceptions\NotFoundException;

class ModelController
{
    protected $table; // 表名
    private $db;
    private $query;

    public function __construct()
    {
        $this->db = new DbController('127.0.0.1', 'starlongwaric', 'root', '19931124');
        $this->query = $this->getDb()->table($this->table);
    }

    private function getDb()
    {
        return $this->db;
    }

    private function collect($array)
    {
        if ($array instanceof Collection) {
            return $array;
        }
        return collect($array);
    }

    public function get()
    {
        $data = $this->query->get();
        return $this->collect($data);
    }

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

    public function where($column, $operator = null, $value = null)
    {
        $this->query = $this->query->where($column, $operator, $value);
        return $this;
    }
}
