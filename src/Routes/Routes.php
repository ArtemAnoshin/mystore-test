<?php

namespace Isibia\Mystore\Routes;

use Exception;
use Isibia\Mystore\Controllers\AuthController;
use Isibia\Mystore\Controllers\OrdersController;

class Routes
{
    private $routes = [
        'GET /' => [AuthController::class, 'index'],
        'POST /auth' => [AuthController::class, 'auth'],
        'GET /orders' => [OrdersController::class, 'index'],
        'POST /orders' => [OrdersController::class, 'getOrders']
    ];

    public function getController()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $host = $_SERVER['SERVER_NAME'];
        $request_uri = $_SERVER['REQUEST_URI'];

        $current_url = parse_url($protocol . '://' . $host . $request_uri);
        $route_match = $method . ' ' . $current_url['path'];

        $route_exists = false;
        foreach ($this->routes as $route => $controller) {
            if ($route === $route_match) {
                $route_exists = true;
                return new $controller[0]($controller[1]);
            }
        }

        if (!$route_exists) {
            throw new Exception('Route not found.');
        }
    }
}
