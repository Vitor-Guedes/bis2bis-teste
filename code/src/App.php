<?php

namespace App;

class App
{
    use Router;

    public function run()
    {
        $this->resolve()->execute();
    }
}