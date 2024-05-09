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
        $orders = $service_api->getOrders();

        if (is_array($orders) && isset($orders['error'])) {
            throw new Exception($orders['error']);
        }

        $statuses = $service_api->getOrderStatuses();

        return $this->buildResponseForOrders($orders, $statuses);
    }

    private function buildResponseForOrders(array $orders, array $statuses): array
    {
        $prepared_orders = [];
        $prepared_statuses = [];

        foreach ($orders['rows'] as $order) {
            $prepared_orders[] = [
                'id' => $order['id'],
                'name' => $order['name'],
                'moment' => $order['moment'],
                'sum' => $order['sum'],
                'link' => $order['meta']['uuidHref'],
                'agent_id' => $order['agent']['id'],
                'agent_href' => $order['agent']['meta']['uuidHref'],
                'agent_name' => $order['agent']['name'],
                'state_id' => $order['state']['id'],
                'state_name' => $order['state']['name'],
                'state_color' => $order['state']['color'],
            ];
        }

        foreach ($statuses['states'] as $status) {
            $prepared_statuses[] = [
                'id' => $status['id'],
                'name' => $status['name'],
                'color' => $status['color'],
            ];
        }

        return [
            'data' => [
                'orders' => $prepared_orders,
                'statuses' => $prepared_statuses,
            ]
        ];
    }
}
