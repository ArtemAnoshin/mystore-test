<?php

use Isibia\Mystore\App;

require 'vendor/autoload.php';

$app = new App;

try {
    // Routing // Logic
    $app->handle();

    // Template
    return $app->response();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
