<?php

namespace TestCase;

use Orm\Controllers\Db;
use Illuminate\Database\Query\Builder;

class DbTest extends TestCase
{
    public function testTable()
    {
        $ctl = new Db([
            'driver' => 'Db',
            'host' => '127.0.0.1',
            'database' => 'test',
            'user' => 'root',
            'password' => '19931124'
        ]);
        $instance = $ctl->table('users');
        $this->assertInstanceOf(Builder::class, $instance);
    }
}
