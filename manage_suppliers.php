<?php

$page_title = "Gerenciar Fornecedores";
include_once "layout_header.php";
include_once "facade.php";

$dao = $factory->getSupplierDao();
$suppliers = $dao->getAll();
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Fornecedores</h1>
            <a
                href="create_supplier.php"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Novo Fornecedor
            </a>
        </div>

        <?php if (count($suppliers) === 0): ?>
            <p class="text-gray-600">Nenhum fornecedor cadastrado.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($suppliers as $supplier): ?>

                    <div class="bg-white p-6 rounded-xl shadow">
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($supplier->getName()) ?></h2>
                        <p class="text-gray-600 mb-4">Description: <?= htmlspecialchars($supplier->getDescription()) ?></p>
                        <div class="flex justify-between">
                            <a
                                href="edit_supplier.php?id=<?= $supplier->getId() ?>"
                                class="text-blue-600 hover:underline">
                                Editar
                            </a>
                            <a
                                href="./actions/admin/supplier/execute_delete_supplier.php?id=<?= $supplier->getId() ?>"
                                class="text-red-600 hover:underline"
                                onclick="return confirm('Tem certeza que deseja excluir este fornecedor?');">
                                Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>