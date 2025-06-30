<?php
require "../../facade.php";

session_start();

// Pega o login digitado pelo usuário
$email = isset($_POST["email"]) ? addslashes(trim($_POST["email"])) : FALSE;

// Pega a senha, a criptografando em MD5 
$password = isset($_POST["password"]) ? md5(trim($_POST["password"])) : FALSE;

if (!$email || !$password) {
    echo "email = " . $email . " / senha = " . $password . "<br>";
    echo "Você deve digitar seu email e senha!<br>";
    echo "<a href='login.php'>Efetuar Login</a>";
    exit;
}

$dao = $factory->getAdministratorDao();
$admin = $dao->searchByEmail($email);

$errors = FALSE;
if ($admin) {  
    if (!strcmp($password, $admin->getPassword())) {
        //Passa os dados para a sessão e redireciona o usuário 
        $_SESSION["user_id"] = $admin->getId();
        $_SESSION["username"] = stripslashes($admin->getName());
        $_SESSION["admin"] = TRUE;

        header("Location: ../../index_admin.php");
        echo 'logged in as ' . $_SESSION["username"] . "<br>";
        exit;
    } else {
        $errors = TRUE;
        echo "Senha inválida!<br>" . $admin->getPassword() . " / " . $password . "<br>";
        exit;
    }
} else {
    $errors = TRUE;
}

echo "email = " . $email . " / senha = " . $password . "<br>";

if ($errors == TRUE) {
    //header("Location: ../../index_admin.php");
    echo "Login ou senha inválidos!<br>";
    exit;
}
