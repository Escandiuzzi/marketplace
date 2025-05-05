<?php
require "../../../facade.php";

$product_id = $_GET['id'] ?? null;
$supplier_id = $_GET['supplier_id'] ?? null;

if (!$product_id) {
    echo "ID do produto não fornecido.";
    exit;
}

if (!$supplier_id) {
    echo "ID do fornecedor não fornecido.";
    exit;
}

$dao = $factory->getProductDao();
$dao->removeById($product_id);

header("Location: /Marketplace/edit_supplier.php?id=" . $supplier_id);
