<?php

namespace App;

class Container
{
    private static $_instance;

    protected $_services = [];

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    public function set(string $name = '', $service)
    {
        if (is_callable($service)) {
            $this->_services[$name] = $service;
        }
    }

    public function get(string $name, $args = [])
    {
        if (isset($this->_services[$name])) {
            if ($args) {
                return call_user_func_array($this->_services[$name], $args);
            }
            return $this->_services[$name]();
        }
    }
}