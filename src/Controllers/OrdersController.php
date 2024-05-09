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
}
