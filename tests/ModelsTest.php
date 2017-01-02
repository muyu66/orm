<?php

namespace TestCase;

use Illuminate\Support\Collection;
use Orm\Models\User;

class ModelsTest extends TestCase
{
    public function testGet()
    {
        $models = new User();
        $models = $models->get();
        $this->assertInstanceOf(Collection::class, $models);
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
        $this->assertEquals($model['id'], 1);
    }

    public function testFirstOrFail()
    {
        $model = new User();
        $this->assertException(function () use ($model) {
            return $model->where('id', 11)->firstOrFail();
        }, 404);
    }
}
