<?php

namespace Code\Admin\Middleware;

use Code\Admin\Model\Session;

class IsLogged
{
    public function __invoke($request, $reponse)
    {
        $session = new Session();

        if ($session->isLogged()) {
            return true;
        }

        $request->redirect('/admin');
    }
}