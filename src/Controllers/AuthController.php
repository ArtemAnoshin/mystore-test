<?php

namespace Isibia\Mystore\Controllers;

use Exception;

class AuthController extends Controller
{
    public function index()
    {
        return [
            'template' => 'auth',
            'data' => [
                'template' => 'auth',
                'data' => []
            ]
        ];
    }

    public function auth()
    {
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$this->validation($login, $password)) {
            throw new Exception('Invalid params');
        }

        return [];
    }

    private function validation($login, $password)
    {
        if (!$login) {
            return false;
        }

        if (!$password) {
            return false;
        }

        if (preg_match('/^admin@.{1,}$/', $login) !== 1) {
            return false;
        }

        return true;
    }
}
