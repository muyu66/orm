<?php

namespace Orm\Controllers\Queries;

interface QueryInterface
{
    public function get();

    public function first();

    public function firstOrFail();

    public function where($params);

    public function update($array);
}
