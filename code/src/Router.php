<?php

namespace App;

use App\Http\Request;
use App\Http\Response;
use App\Http\ResponseCode;

trait Router
{
    protected $_prefix;

    protected $_routes = [];

    /**
     * @param string $path
     * @param $callback
     */
    public function get(string $path, $callback)
    {
        $this->add('get', $path, $callback);
    }

    /**
     * @param string $path
     * @param $callback
     */
    public function post(string $path, $callback)
    {
        $this->add('post', $path, $callback);
    }

    /**
     * @param string $method GET|POST
     * @param string $path
     * @param $callback
     */
    protected function add(string $method, $path, $callback)
    {
        if ($this->_prefix) {
            $path = $this->_prefix . $path;
        }
        $this->_routes[$method][] = new Route($path, $callback);
    }

    /**
     * Search and identify route requested
     * @return Route
     */
    protected function resolve()
    {
        $request = new Request();

        $routes = $this->_routes[$request->getMethod()] ?? [];
        foreach ($routes as $route) {
            if ($route->match($request->getUri())) {
                return $route;
            }
        }

        $noRoute = new Route($request->getUri(), function (Request $request, Response $response) {
            return $response->setBody("Error 404", ResponseCode::HTTP_NOT_FOUNDED);
        });

        return $noRoute;
    }

    /**
     * @param string $prefix
     * @param $callback
     */
    public function group(string $prefix = '', $callback)
    {
        $this->_prefix = $prefix;

        $callback($this);

        $this->_prefix = '';
    }
}