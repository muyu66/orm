<?php

namespace TestCase;

use Orm\Controllers\Connections\Connection;
use Orm\Controllers\Drivers\RedisDriver;
use Orm\Models\User;
use Predis\Client;

class RedisDriverTest extends TestCase
{
    public function testA()
    {
        $host = '127.0.0.1';
        $port = '6379';
        $database = '4';
        $password = 'muyuzhouyu1M';
        $redis = new Client(compact('host', 'port', 'database', 'password'));

        Connection::create($redis);

//        $models = new User();
//        dump($models->get());

//        $models = new User();
//        dump($models->find('1'));

        $models = new User();
        dump($models->where('name', '=', 'aaa')->get());

//        $model = new User();
//        $model->id = 1;
//        $model->name = 'aaa';
//        $model->save();
    }

//    public function testB()
//    {
//        $models = new User();
//        foreach ($models as $model) {
//            dump($model);
//        }
//    }
}
