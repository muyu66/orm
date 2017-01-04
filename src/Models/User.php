<?php

namespace Orm\Models;

use Orm\Controllers\Model;

class User extends Model
{
    public $table = 'users';

    public function user2()
    {
        return $this->hasMany(User2::class, 'user_id', 'id');
    }
}
