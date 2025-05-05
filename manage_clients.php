<?php
require "facade.php";

$page_title = "Gerenciar Usuários";

$dao = $factory->getClientDao();
$search = $_GET['search'] ?? '';
$all_users = $dao->getAll();
$users = $search
    ? array_filter($all_users, function($user) use ($search) {
        return stripos($user->getName(), $search) !== false;
    })
    : $all_users;
?>

<?php include_once "layout_header.php"; ?>

<section class="p-6 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Gerenciar Usuários</h1>
        <a href="create_client_admin.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Usuário</a>
    </div>

    <form method="GET" class="mb-4 flex gap-2">
        <input
            type="text"
            name="search"
            placeholder="Buscar por nome..."
            value="<?= htmlspecialchars($search) ?>"
            class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">Buscar</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="p-4">Nome</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Número</th>
                    <th class="p-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Nenhum usuário encontrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b">
                            <td class="p-4"><?= htmlspecialchars($user->getName()) ?></td>
                            <td class="p-4"><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td class="p-4"><?= htmlspecialchars($user->getNumber()) ?></td>
                            <td class="p-4 flex gap-2">
                                <a href="edit_user.php?id=<?= $user->getId() ?>" class="text-blue-600 hover:underline">Editar</a>
                                <a href="./actions/admin/client/execute_client_delete.php?id=<?= $user->getId() ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>