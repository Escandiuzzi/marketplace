<?php
$page_title = "Admin Dashboard";
include_once "layout_header.php";
require_once "auth_admin.php";
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Painel do Administrador</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="manage_clients.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold mb-2">Gerenciar Usuários</h2>
                <p class="text-gray-600">Adicionar, editar ou remover usuários do sistema.</p>
            </a>

            <a href="view_orders.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold mb-2">Visualizar Pedidos</h2>
                <p class="text-gray-600">Acompanhar pedidos realizados pelos clientes.</p>
            </a>

            <a href="manage_suppliers.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold mb-2">Gerenciar Fornecedores</h2>
                <p class="text-gray-600">Adicionar, editar ou remover fornecedores do sistema.</p>
            </a>
        </div>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>