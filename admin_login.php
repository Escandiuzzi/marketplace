<?php
$page_title = "Marketplace - Admin Login";
include_once "layout_header.php";

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == TRUE) {
        header("Location: index_admin.php");
    } else {
        header("Location: index.php");
    }
} 

?>

<section class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-red-600 mb-6">Admin Login</h2>

        <form action="./actions/login/execute_admin_login.php" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    placeholder="Informe o email do administrador" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                >
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Senha</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Informe a senha" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-200"
            >
                Entrar como Admin
            </button>
        </form>

        <div class="mt-6 text-center">
            <a 
                href="login.php" 
                class="text-blue-500 hover:underline"
            >
                Voltar para o login do usuário
            </a>
        </div>
    </div>
</section>
<?php
include_once "layout_footer.php";
?>