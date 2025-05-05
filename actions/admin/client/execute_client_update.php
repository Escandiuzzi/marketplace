<?php
require "../../../facade.php";

$required = ['id', 'number', 'name', 'email'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        die("Erro: Campo obrigatório '$field' não foi preenchido.");
    }
}

function clean($value)
{
    return htmlspecialchars(trim($value));
}

$errors = [];

$id = (int) ($_POST['id'] ?? 0);
$number = clean($_POST['number'] ?? '');
$name = clean($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

$street = clean($_POST['street'] ?? '');
$address_number = clean($_POST['address_number'] ?? '');
$complement = clean($_POST['complement'] ?? '');
$neighborhood = clean($_POST['neighborhood'] ?? '');
$city = clean($_POST['city'] ?? '');
$state = clean($_POST['state'] ?? '');
$zip = clean($_POST['zip'] ?? '');

if ($id <= 0) $errors[] = "ID inválido.";
if (!$number) $errors[] = "Número é obrigatório.";
if (!$name) $errors[] = "Nome é obrigatório.";
if (!$email) $errors[] = "Email inválido.";

if (!empty($errors)) {
    echo "<h3>Erros encontrados:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    exit;
}

$address = new Address($street, $address_number, $complement, $neighborhood, $city, $state, $zip);

$dao = $factory->getClientDao();
$existingClient = $dao->searchById($id);

$finalPassword = $password ? $password : $existingClient->getPassword();

$client = new Client($id, $number, $email, $finalPassword, $name, $address, $existingClient->getCreditCard());

$dao->update($client);

header("Location: ../../../manage_clients.php");