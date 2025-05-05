<?php
require "../../../facade.php";

$client_id = $_GET['id'] ?? null;

if (!$client_id) {
    echo "ID do cliente não fornecido.";
    exit;
}

$dao = $factory->getClientDao();
$dao->removeById($client_id);

header("Location: ../../../manage_clients.php");