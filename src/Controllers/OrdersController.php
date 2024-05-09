<?php

namespace Isibia\Mystore\Controllers;

use Exception;
use Isibia\Mystore\Services\MyStorageApiHandlerService;

class OrdersController extends Controller
{
    public function index()
    {
        $this->onlyWithToken();

        return [
            'template' => 'orders',
            'data' => []
        ];
    }

    public function getOrders()
    {
        $this->onlyWithToken();

        $service_api = new MyStorageApiHandlerService();
        $response = $service_api->getOrders();

        if (is_array($response) && isset($response['error'])) {
            throw new Exception($response['error']);
        }

        return [
            'data' => $response
        ];
    }
}
