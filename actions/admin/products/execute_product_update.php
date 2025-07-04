<?php
require "../../../facade.php";

$required = ['id', 'name', 'price', 'quantity'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '') {
        die("Erro: Campo obrigatório '$field' não foi preenchido.");
    }
}

function clean($value)
{
    return htmlspecialchars(trim($value));
}

$errors = [];

$id = (int) ($_POST['id'] ?? 0);
$name = clean($_POST['name'] ?? '');
$description = clean($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 0);
$supplier_id = isset($_POST['supplier_id']) && $_POST['supplier_id'] !== '' ? (int) $_POST['supplier_id'] : null;

if ($id <= 0) $errors[] = "ID do produto é inválido.";
if (empty($name)) $errors[] = "Nome é obrigatório.";
if ($price < 0) $errors[] = "Preço não pode ser negativo.";
if ($quantity < 0) $errors[] = "Quantidade não pode ser negativa.";

if (!empty($errors)) {
    echo "<h3>Erros encontrados:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    exit;
}

$dao = $factory->getProductDao();
$oldProduct = $dao->searchById($id);

$image = null;
if (!empty($_POST['remove_image'])) {
} elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['image']['tmp_name'];

    $image = file_get_contents($imageTmpPath);
} else {
    $image = $oldProduct->getImage();
}

$stock = new Stock($quantity, $price);
$product = new Product($id, $supplier_id, $name, $description, $image, $stock);

$dao = $factory->getProductDao();
$dao->update($product);

header("Location: /Marketplace/edit_supplier.php?id=" . $supplier_id);
