<?php
require "../../../facade.php";

// Validate required POST fields
$required = ['id', 'number', 'name', 'description'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Erro: Campo obrigatório '$field' não foi preenchido.");
    }
}

function clean($value)
{
    return htmlspecialchars(trim($value));
}

$errors = [];

// Sanitize/validate inputs
$id = (int) ($_POST['id'] ?? 0);
$number = clean($_POST['number'] ?? '');
$name = clean($_POST['name'] ?? '');
$description = clean($_POST['description'] ?? '');

$street = clean($_POST['street'] ?? '');
$address_number = clean($_POST['address_number'] ?? '');
$complement = clean($_POST['complement'] ?? '');
$neighborhood = clean($_POST['neighborhood'] ?? '');
$city = clean($_POST['city'] ?? '');
$state = clean($_POST['state'] ?? '');
$zip = clean($_POST['zip'] ?? '');

// Basic validation
if (empty($id)) $errors[] = "ID do fornecedor é obrigatório.";
if (empty($number)) $errors[] = "Número do fornecedor é obrigatório.";
if (empty($name)) $errors[] = "Nome é obrigatório.";
if (empty($description)) $errors[] = "Descrição é obrigatória.";

// Stop if errors exist
if (!empty($errors)) {
    echo "<h3>Erros encontrados:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    exit;
}

$address = new Address($street, $address_number, $complement, $neighborhood, $city, $state, $zip);
$supplier = new Supplier($id, $number, $name, $address, $description);

$dao = $factory->getSupplierDao();
$dao->update($supplier);

header("Location: ../../../manage_suppliers.php");
