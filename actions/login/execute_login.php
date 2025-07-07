<?php
require "../../facade.php";

session_start();

$email = isset($_POST["email"]) ? addslashes(trim($_POST["email"])) : FALSE;
$password = isset($_POST["password"]) ? md5(trim($_POST["password"])) : FALSE;

if (!$email || !$password) {
    echo "email = " . $email . " / senha = " . $password . "<br>";
    echo "Você deve digitar seu email e senha!<br>";
    echo "<a href='login.php'>Efetuar Login</a>";
    exit;
}

$dao = $factory->getClientDao();
$client = $dao->searchByEmail($email);

$errors = FALSE;
if ($client) {  
    if (!strcmp($password, $client->getPassword())) {
        //Passa os dados para a sessão e redireciona o usuário 
        $_SESSION["user_id"] = $client->getId();
        $_SESSION["username"] = stripslashes($client->getName());
        $_SESSION["admin"] = FALSE;
       
        header("Location: ../../index.php");
        echo 'logged in as ' . $_SESSION["username"] . "<br>";
        exit;
    } else {
        $errors = TRUE;
        echo "Senha inválida!<br>" . $client->getPassword() . " / " . $password . "<br>";
        exit;
    }
} else {
    $errors = TRUE;
}

echo "login = " . $login . " / senha = " . $password . "<br>";

if ($errors == TRUE) {
    header("Location: ../../login.php");
    echo "Login ou senha inválidos!<br>";
    exit;
}
