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
            $this->_services[$name] = [
                'called' => false,
                'callable' => $service
            ];
        }
    }

    public function get(string $name, $args = [])
    {
        $service = $this->_services[$name] ?? false;
        if ($service) {
            if ($service['called'] == false) {
                $callable = $service['callable'];
    
                $result = call_user_func_array($callable, $args);
                
                $service['called'] = true;
                $service['callable'] = $result;

                $this->_services[$name] = $service;
    
                return $result;
            }
            return $service['callable'];
        }
        return $service;
    }
}