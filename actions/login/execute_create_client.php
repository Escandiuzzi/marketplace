<?php
require "../../facade.php";

function clean($value)
{
    return htmlspecialchars(trim($value));
}

$errors = [];

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

$card_number = clean($_POST['card_number'] ?? '');
$expiration_date = clean($_POST['expiration_date'] ?? '');
$cvv = clean($_POST['cvv'] ?? '');
$holder_name = clean($_POST['holder_name'] ?? '');

// Basic validations
if (!$number) $errors[] = "Número é obrigatório.";
if (!$name) $errors[] = "Nome é obrigatório.";
if (!$email) $errors[] = "Email inválido ou ausente.";
if (!$password || strlen($password) < 6) $errors[] = "Senha deve ter no mínimo 6 caracteres.";


if (!empty($errors)) {
    echo "<h3>Erros no envio do formulário:</h3><ul>";
    foreach ($errors as $err) echo "<li>$err</li>";
    echo "</ul><a href='novo_usuario.php'>Voltar</a>";
    exit;
}

$address = new Address($street, $address_number, $complement, $neighborhood, $city, $state, $zip);
$creditCard = new CreditCard($card_number, $expiration_date, $cvv, $holder_name);
$client = new Client(0, $number, $email, $password,$name, $address, $creditCard);

$dao = $factory->getClientDao();
$dao->insert($client);

header("Location: ../../login.php");
