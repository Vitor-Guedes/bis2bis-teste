<?php

namespace App\Mvc;

use App\Database\Builder;

abstract class Model
{
    use Builder;

    public $_data;

    public function find(int $id)
    {

    }

    public function all()
    {

    }

    public function save()
    {

    }

    public function delete(int $id)
    {

    }
}