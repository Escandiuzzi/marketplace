<?php
$page_title = "Marketplace - Login";
include_once "layout_header.php";


if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == TRUE) {
        header("Location: index_admin.php");
    } else {
        header("Location: index.php");
    }
}

?>
<section class="relative flex items-center justify-center min-h-screen bg-gray-100">

    <div class="absolute top-4 right-4">
        <a
            href="admin_login.php"
            class="text-sm bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-200">
            Login como Administrador
        </a>
    </div>

    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

        <form action="./actions/login/execute_login.php" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder="Informe o email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Informe a senha"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Entrar
            </button>
        </form>

        <div class="mt-6 text-center">
            <a
                href="create_client.php"
                class="inline-block w-full bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition duration-200">
                Novo Usuário
            </a>
        </div>
    </div>
</section>
<?php
include_once "layout_footer.php";
?>