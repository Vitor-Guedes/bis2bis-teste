<?php

namespace Code\Admin\Model;

use App\Mvc\Model;

class User
extends Model
{
    protected $_table = 'admin_user';

    public function authenticate(string $username, string $password)
    {
        $this->where('username', 'like', $username)
            ->andWhere('password', 'like', $password)
            ->get();
    }
}
