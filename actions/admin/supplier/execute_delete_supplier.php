<?php
require "../../../facade.php";

$supplier_id = $_GET['id'] ?? null;

if (!$supplier_id) {
    echo "ID do fornecedor não fornecido.";
    exit;
}

$dao = $factory->getSupplierDao();
$dao->removeById($supplier_id);


header("Location: ../../../manage_suppliers.php");
