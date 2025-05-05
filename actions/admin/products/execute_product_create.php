<?php
require "../../../facade.php";

// Function to clean inputs
function clean($value)
{
    return htmlspecialchars(trim($value));
}

$errors = [];

$name = clean($_POST['name'] ?? '');
$description = clean($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$supplier_id = $_POST['supplier_id'] ?? '';

if (!$name) $errors[] = "Nome do produto é obrigatório.";
if (!$description) $errors[] = "Descrição é obrigatória.";
if (!$price || !is_numeric($price) || $price <= 0) $errors[] = "Preço é obrigatório e deve ser um número positivo.";
if (!$quantity || !is_numeric($quantity) || $quantity < 0) $errors[] = "Quantidade é obrigatória e deve ser um número não negativo.";
if (!$supplier_id || !is_numeric($supplier_id) || $supplier_id <= 0) $errors[] = "Fornecedor é obrigatório e inválido.";

if (!empty($errors)) {
    echo "<h3>Erros no envio do formulário:</h3><ul>";
    foreach ($errors as $err) echo "<li>$err</li>";
    echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    exit;
}

$stock = new Stock($quantity, $price);
$product = new Product(0, $supplier_id, $name, $description, $stock);

$dao = $factory->getProductDao();
$dao->insert($product);

header("Location: /Marketplace/edit_supplier.php?id=" . $supplier_id);

?>