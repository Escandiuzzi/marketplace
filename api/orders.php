<?php
function handleOrdersRequest($method, $orderDao, $id, $name)
{
    switch ($method) {
        case 'GET':
            if ($id) {
                $result = $orderDao->searchById((int)$id);
                echo json_encode($result ?? ["message" => "Order not found"]);;
            } else if ($name) {
                $result = $orderDao->getAllByClientName($name);
                echo json_encode($result ?? ["message" => "Order not found"]);;
            } else {
                $result = $orderDao->getAll();
                echo json_encode($result ?? ["message" => "Order not found"]);;
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            break;
    }
}
