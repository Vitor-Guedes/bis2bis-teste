<?php

namespace App\Http;

class Request
{
    protected $_method;
    
    protected $_uri;

    /**
     * Retrive Request Method
     * 
     * @return string
     */
    public function getMethod()
    {
        if (!$this->_method) {
            $this->_method = strtolower($_SERVER['REQUEST_METHOD']);
        }
        return $this->_method;
    }

    /**
     * Retrive Request Uri
     * 
     * @return string
     */
    public function getUri()
    {
        if (!$this->_uri) {
            $this->_uri = $_SERVER['REQUEST_URI'];
        }
        return $this->_uri;
    }

    public function getParams()
    {
        if ($this->isGet()) {
            return $_GET;
        }

        if ($this->isPost()) {
            return $_POST;
        }

        return $_REQUEST;
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function redirect(string $location = '')
    {
        Header("Location: $location", true, 301);
    }
}