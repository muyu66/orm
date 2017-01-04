<?php

namespace TestCase;

use Orm\Controllers\Drivers\Db;
use Illuminate\Database\Query\Builder;

class DbTest extends TestCase
{
    public function testTable()
    {
        $ctl = new Db(get_config_test());
        $instance = $ctl->table('users');
        $this->assertInstanceOf(Builder::class, $instance);
    }
}
