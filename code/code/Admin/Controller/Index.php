<?php 

namespace Code\Admin\Controller;

use App\Mvc\Controller;
use Code\Admin\Model\Session;

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

        $session = new Session();
        $session->authenticate($username, $password);

        if ($session->isLogged()) {
            $request->redirect('/admin/dash');
        }

        $request->redirect('/admin');

        return $response;
    }

    public function dash($request, $response)
    {
        return $this->_view->render($response, 'dashboard.phtml', [
            'title' => "Dashboard"
        ]);
    }

    public function loggout($request, $response)
    {
        $session = new Session();
        $session->loggout();

        $request->redirect('/admin');
    }

    protected function getViewPath()
    {
        return dirname(__DIR__) . '/view/';
    }
}