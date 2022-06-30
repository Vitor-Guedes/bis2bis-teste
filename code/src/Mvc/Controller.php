<?php

namespace App\Mvc;

use App\Container;

abstract class Controller
{
    protected $_view;

    public function __construct()
    {
        $this->_view = Container::getInstance()->get('view');
        $this->_view->setTemplatePath($this->getViewPath());   
    }

    protected abstract function getViewPath();
}