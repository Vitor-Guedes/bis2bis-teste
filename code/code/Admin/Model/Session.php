<?php

namespace Code\Admin\Model;

use App\Model\Session as ModelSession;

class Session
extends ModelSession
{
    protected $_sessionName = 'admin_user';

    public function authenticate($username, $password)
    {
        $admin = new User();
        $admin->authenticate($username, $password);

        $isLogged = false;
        if (isset($admin->id)) {
            $isLogged = true;
            $this->setIsLogged($isLogged);
            $this->setUser($admin);

            return $isLogged;
        }
        return $isLogged;
    }

    protected function setIsLogged(bool $flag)
    {
        $this->setData('is_logged', $flag);
    }

    public function isLogged()
    {
        return $this->getData('is_logged');
    }

    public function setUser(User $user)
    {
        $userData = $user->toJson();
        $this->setData('admin', $userData);
    }

    public function getUser()
    {
        $user = new User();
        $userData = $this->getData('admin');
        $data = json_decode($userData);

        foreach ($data as $key => $value) {
            $user->$key = $value;
        }
        return $user;
    }

    public function loggout()
    {
        unset($_SESSION[$this->_sessionName]);
    }
}