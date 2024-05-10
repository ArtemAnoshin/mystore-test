<?php

namespace Isibia\Mystore\Controllers;

use Exception;
use Isibia\Mystore\Services\MyStorageApiHandlerService;

class OrdersController extends Controller
{
    /**
     * Выводит страницу с заказами
     */
    public function index()
    {
        $this->onlyWithToken();

        return [
            'template' => 'orders',
            'data' => []
        ];
    }

    /**
     * Вернет список всех заказов
     */
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

    /**
     * Запрос на изменение статуса заказа
     */
    public function changeStatus()
    {
        $this->onlyWithToken();

        $body = json_decode(file_get_contents('php://input'), true);
        $data = $body ? $body['data'] : null;

        if (!$data) {
            return [
                'data' => []
            ];
        }

        $service_api = new MyStorageApiHandlerService();
        $result = $service_api->changeStatus($data);

        if (is_array($result) && isset($result['error'])) {
            throw new Exception($result['error']);
        }

        return [
            'data' => $result
        ];
    }

    /**
     * Подготовка данных для вывода в шаблон при получении заказов
     */
    private function buildResponseForOrders(array $orders, array $statuses): array
    {
        $prepared_orders = [];
        $prepared_statuses = [];

        if (!empty($orders['rows'])) {
            foreach ($orders['rows'] as $order) {
                $prepared_orders[] = [
                    'id'          => isset($order['id']) ? htmlspecialchars($order['id']) : null,
                    'name'        => isset($order['name']) ? htmlspecialchars($order['name']) : null,
                    'moment'      => isset($order['moment']) ? htmlspecialchars($order['moment']) : null,
                    'sum'         => isset($order['sum']) ? htmlspecialchars($order['sum']) : null,
                    'link'        => isset($order['meta']['uuidHref']) ? htmlspecialchars($order['meta']['uuidHref']) : null,
                    'agent_id'    => isset($order['agent']['id']) ? htmlspecialchars($order['agent']['id']) : null,
                    'agent_href'  => isset($order['agent']['meta']['uuidHref']) ? htmlspecialchars($order['agent']['meta']['uuidHref']) : null,
                    'agent_name'  => isset($order['agent']['name']) ? htmlspecialchars($order['agent']['name']) : null,
                    'state_id'    => isset($order['state']['id']) ? htmlspecialchars($order['state']['id']) : null,
                    'state_name'  => isset($order['state']['name']) ? htmlspecialchars($order['state']['name']) : null,
                    'state_color' => isset($order['state']['color']) ? htmlspecialchars($order['state']['color']) : null,
                ];
            }
        }

        if (!empty($statuses['states'])) {
            foreach ($statuses['states'] as $status) {
                $prepared_statuses[] = [
                    'id'    => isset($status['id']) ? htmlspecialchars($status['id']) : null,
                    'name'  => isset($status['name']) ? htmlspecialchars($status['name']) : null,
                    'color' => isset($status['color']) ? htmlspecialchars($status['color']) : null,
                ];
            }
        }

        return [
            'data' => [
                'orders' => $prepared_orders,
                'statuses' => $prepared_statuses,
            ]
        ];
    }
}
