<?php

namespace TestCase;

use Orm\Controllers\Connections\Connection;
use Orm\Models\User;
use Predis\Client;

class RedisTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $host = '127.0.0.1';
        $port = '6379';
        $database = '4';
        $password = 'muyuzhouyu1M';
        $redis = new Client(compact('host', 'port', 'database', 'password'));

        $redis->flushdb();

        Connection::create($redis);

        $this->testSave();
    }

    public function testSave()
    {
        $model = new User();
        $model->name = 'aaa';
        $model->save();
    }

    public function testFind()
    {
        $models = new User();
        $this->assertTrue($models->find(1)->name === 'aaa');
    }

    public function testGet()
    {
        $models = new User();
        $this->assertTrue(is_array($models->get()));
    }
}
