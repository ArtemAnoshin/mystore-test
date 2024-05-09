<?php

namespace Isibia\Mystore\Services;

class MyStorageApiHandlerService
{
    const GET_TOKEN_URL = 'https://api.moysklad.ru/api/remap/1.2/security/token';

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

        return $response;
    }
}