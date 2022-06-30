<?php

namespace App\Model;

class Session
{
    protected $_sessionName;

    public function __construct()
    {
        session_start();

        $this->init();
    }

    protected function init()
    {
        if (!isset($_SESSION[$this->_sessionName])) {
            $_SESSION[$this->_sessionName] = [];
        }
    }

    protected function setData(string $key = '', $value)
    {
        $_SESSION[$this->_sessionName][$key] = $value;
    }

    protected function getData(string $key)
    {
        return $_SESSION[$this->_sessionName][$key] ?? false;
    }
}