<?php

namespace Orm\Controllers\Queries;

interface QueryInterface
{
    public function getTableName();

    public function setTableName($table_name);

    public function get($params);

    public function find($params);

    public function save($params);
}
