<?php

namespace Isibia\Mystore;

use Isibia\Mystore\Routes\Routes;

final class App
{
    const TEMPLATE_PATH = 'src/Templates/';

    private array $responseData = [];

    // Routing, Logic
    public function handle()
    {
        $routes = new Routes;
        $controller = $routes->getController();
        $this->responseData = $controller->handle();
    }

    public function response()
    {
        $template = $this->responseData()['template'] ?? null;
        $data = $this->responseData()['data'] ?? null;
        $redirect = $this->responseData()['redirect'] ?? null;

        // Redirect
        if ($redirect) {
            header("Location: $redirect");
            exit();
        }

        // JSON
        if (!$template) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
            die;
        }

        // HTML
        include_once self::TEMPLATE_PATH . $this->template($template);
    }

    /**
     * Get template
     */
    private function template($template) : string
    {
        return $template . '.template.php';
    }
    
    private function responseData()
    {
        return $this->responseData;
    }
}
