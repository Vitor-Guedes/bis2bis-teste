<?php 

namespace Code\Admin\Controller;

use App\Mvc\Controller;

class Index
extends Controller
{
    public function login($request, $response)
    {
        return $this->_view->render($response, 'login.phtml', [
            'title' => "Login Admin"
        ]);
    }

    public function authenticate($request, $response)
    {
        $params = $request->getParams();
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';
        
        if ($username && $password) {
            if ($username == 'admin' && $password == 'admin') {
                $request->redirect('/admin/dash');
            }
        }

        return $response;
    }

    public function dash($request, $response)
    {
        $response->setBody("#Dash");

        return $response;
    }

    protected function getViewPath()
    {
        return dirname(__DIR__) . '/view/';
    }
}