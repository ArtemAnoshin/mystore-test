<?php

namespace Isibia\Mystore\Controllers;

class AuthController extends Controller
{
    public function index()
    {
        return [
            'template' => 'auth',
            'data' => [
                'template' => 'auth',
                'data' => []
            ]
        ];
    }
}