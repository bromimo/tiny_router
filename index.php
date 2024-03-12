<?php

use core\Route;

function autoloadMainClasses($class_name){
    $class_name = str_replace('\\','/', $class_name);
    @include_once $class_name . '.php';
}

spl_autoload_register('autoloadMainClasses');

$vendor_path = __DIR__ . '/vendor/autoload.php';
if (file_exists($vendor_path)) {
    require_once $vendor_path;
}
require_once __DIR__ . '/routes/api.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

echo Route::dispatch($requestMethod, $requestUri);

