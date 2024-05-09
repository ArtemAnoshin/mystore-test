<?php

namespace Isibia\Mystore\Controllers;

use Exception;
use Isibia\Mystore\Services\MyStorageApiHandlerService;

class AuthController extends Controller
{
    public function index()
    {
        session_start();

        if (!empty($_SESSION['token'])) {
            return [
                'redirect' => '/orders',
                'data' => []
            ];
        }

        return [
            'template' => 'auth',
            'data' => []
        ];
    }

    public function auth()
    {
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$this->validation($login, $password)) {
            throw new Exception('Invalid params');
        }

        // Make request to МойСклад
        $service = new MyStorageApiHandlerService();
        $response = $service->getToken($login, $password);

        if (is_array($response) && isset($response['error'])) {
            throw new Exception($response['error']);
        }

        session_start();

        $_SESSION['token'] = $response; 

        return [
            'redirect' => '/orders',
            'data' => []
        ];
    }

    /**
     * Validate login and password
     */
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
