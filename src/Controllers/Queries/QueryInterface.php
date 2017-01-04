<?php

namespace Orm\Controllers\Queries;

use Orm\Controllers\Model;

interface QueryInterface
{
    public function get();

    public function first();

    public function firstOrFail();

    public function where($params);

    public function update($array);

    public function with($target, $foreign_key, $local_key);
}
