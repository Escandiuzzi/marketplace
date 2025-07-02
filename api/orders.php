<?php

function handleOrdersRequest($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                echo json_encode(["client" => "Get client $id"]);
            } else {
                echo json_encode(["clients" => ["Client 1", "Client 2"]]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(["message" => "Client created", "data" => $data]);
            break;

        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["message" => "Missing client ID"]);
                return;
            }
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(["message" => "Client $id updated", "data" => $data]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["message" => "Missing client ID"]);
                return;
            }
            echo json_encode(["message" => "Client $id deleted"]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            break;
    }
}
