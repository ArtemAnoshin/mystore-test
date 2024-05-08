<?php

namespace Isibia\Mystore\Controllers;

abstract class Controller
{
    public $action;

    public function __construct(string $action)
    {
        $this->action = $action;
    }

    public function handle()
    {
        return call_user_func(array($this, $this->action));
    }
}
