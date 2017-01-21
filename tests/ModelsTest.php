<?php

namespace TestCase;

use Orm\Models\User;

class ModelsTest extends TestCase
{
    public function testGet()
    {
        $models = new User();
        $models = $models->get();
        $this->assertTrue(is_array($models) && ! empty($models));
    }

    public function testWhere()
    {
        $models = new User();
        $models = $models->where('id', 1)->get();
        $this->assertEquals(count($models), 1);
    }

    public function testFirst()
    {
        $model = new User();
        $model = $model->where('id', 1)->first();
        $this->assertEquals($model->id, 1);
    }

    public function testFirstOrFail()
    {
        $model = new User();
        $this->assertException(function () use ($model) {
            return $model->where('id', 11)->firstOrFail();
        }, 404);
    }

    public function testSave()
    {
        // 单个数据 save
        $model = new User();
        $model = $model->where('id', 1)->first();
        $model->test = rand(1, 1000000);
        $this->assertEquals(1, $model->save());

        // 多个数据 save
        $models = new User();
        $models = $models->get();
        foreach ($models as $model) {
            $model->test = rand(1, 100000);
            $this->assertEquals(1, $model->save());
        }
    }

    public function testWith()
    {
        $model = new User();
        $result = $model->user2()->get();
        $this->assertEquals(1, count($result));
    }
}
