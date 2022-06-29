<?php

namespace App;

use App\Http\{Request, Response};
use Exception;
use LDAP\Result;

class Route
{
    protected $_path;

    protected $_pattern;

    protected $_callable;

    /**
     * @param string $path
     * @param callable|string $callable
     */
    public function __construct(string $path = '', $callable)
    {
        $this->_path = $path;
        $this->_callable = $callable;
    }

    /**
     * Create structure to be identified through the regex
     * 
     * @return string
     */
    protected function getPattern()
    {
        if (!$this->_pattern) {
            $pattern = str_replace("/", "\/", $this->_path);
            $pattern = "/^{$pattern}$/";
            $this->_pattern = $pattern;
        }
        return $this->_pattern;
    }

    /**
     * Compare the url with the route's regex pattern
     * 
     * @param string $uri
     * @return bool
     */
    public function match(string $uri = '')
    {
        return (bool) preg_match($this->getPattern(), $uri);
    }

    /**
     * Run callable from route
     */
    public function execute()
    {   
        $response = is_string($this->_callable) 
            ? $this->execStringCallable() 
                : $this->execCallable() ;

        if ($response instanceof Response) {
            return $response->send();
        }
    }

    protected function execStringCallable()
    {
        $callable = $this->_callable;
        $callable = explode("@", $callable);

        if (count($callable) == 2) {
            $controller = array_shift($callable);
            $action = array_shift($callable);

            if (!class_exists($controller)) {
                throw new Exception("Class $controller not exists.");
            }

            $instance = new $controller();
            if (!method_exists($instance, $action)) {
                throw new Exception("Method $action in Class $controller not exist.");
            }

            return $instance->$action(new Request(), new Response());
        }

        return false;
    }

    protected function execCallable()
    {
        $callable = $this->_callable;
        return $callable(new Request(), new Response());
    }
}