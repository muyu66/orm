<?php

namespace Orm\Commons;

use stdClass;

class Row extends stdClass
{
    public function __construct($obj)
    {
        $arrays = json_decode(json_encode($obj), true);
        foreach ($arrays as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __call($method, $params)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $params);
        }
        return 'not found this method';
    }
}
