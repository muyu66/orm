<?php

namespace TestCase;

use Orm\Controllers\DbController;
use Illuminate\Database\Query\Builder;

class DbTest extends TestCase
{
    public function testTable()
    {
        $ctl = new DbController('127.0.0.1', 'starlongwaric', 'root', '19931124');
        $instance = $ctl->table('users');
        $this->assertInstanceOf(Builder::class, $instance);
    }
}
