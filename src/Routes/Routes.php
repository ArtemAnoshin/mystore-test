<?php

namespace Isibia\Mystore\Routes;

use Exception;
use Isibia\Mystore\Controllers\AuthController;

class Routes
{
    private $routes = [
        'GET /' => [AuthController::class, 'index'],
        'POST /get_token' => [AuthController::class, 'getToken'],
        //'GET /orders' => [OrdersController::class, 'index']
    ];

    public function getController()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $host = $_SERVER['SERVER_NAME'];
        $request_uri = $_SERVER['REQUEST_URI'];

        $current_url = parse_url($protocol . '://' . $host . $request_uri);
        $route_match = $method . ' ' . $current_url['path'];

        foreach ($this->routes as $route => $controller) {
            if ($route === $route_match) {
                return new $controller[0]($controller[1]);
            }

            throw new Exception('Route not found');
        }
    }
}
