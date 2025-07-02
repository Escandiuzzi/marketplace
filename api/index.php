<?php
header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

if ($uri[1] !== 'api') {
    http_response_code(404);
    echo json_encode(["message" => "Not Found"]);
    exit;
}

$resource = $uri[2] ?? null;
$id = $uri[3] ?? null;

switch ($resource) {
    case 'orders':
        require 'orders.php';
        handleOrdersRequest($requestMethod, $id);
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Resource not found"]);
        break;
}
