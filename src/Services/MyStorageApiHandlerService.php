<?php

namespace Isibia\Mystore\Services;

class MyStorageApiHandlerService
{
    const GET_TOKEN_URL = 'https://api.moysklad.ru/api/remap/1.2/security/token';
    const GET_ORDERS = 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder?order=moment,desc&limit=100&expand=agent,state';
    const GET_STATUSES = 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata';

    public function getToken(string $login, string $password): array|string
    {
        $credentials = base64_encode($login . ':' . $password);

        $headers = [
            'Accept-Encoding: gzip',
            'Authorization: Basic ' . $credentials,
        ];

        $ch = curl_init(self::GET_TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (!$response) {
            $errno = curl_errno($ch);
            $message = curl_strerror($errno);
            $response = [
                'error' => "cURL error ({$errno}):\n {$message}"
            ];
        }

        curl_close($ch);

        return json_decode($response, true)['access_token'];
    }

    public function getOrders()
    {
        session_start();

        $token = $_SESSION['token'];

        $headers = [
            'Authorization: Bearer ' . $token,
            'Accept-Encoding: gzip',
        ];

        $ch = curl_init(self::GET_ORDERS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING ,"");

        $response = curl_exec($ch);

        if (!$response) {
            $errno = curl_errno($ch);
            $message = curl_strerror($errno);
            $response = [
                'error' => "cURL error ({$errno}):\n {$message}"
            ];
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function getOrderStatuses()
    {
        session_start();

        $token = $_SESSION['token'];

        $headers = [
            'Authorization: Bearer ' . $token,
            'Accept-Encoding: gzip',
        ];

        $ch = curl_init(self::GET_STATUSES);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING ,"");

        $response = curl_exec($ch);

        if (!$response) {
            $errno = curl_errno($ch);
            $message = curl_strerror($errno);
            $response = [
                'error' => "cURL error ({$errno}):\n {$message}"
            ];
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}