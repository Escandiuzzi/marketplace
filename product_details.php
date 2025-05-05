<?php
$page_title = "Detalhes do Produto";
include_once "layout_header.php";
include_once "facade.php";

$productId = $_GET['id'] ?? null;
$productDao = $factory->getProductDao();

if (!$productId || !$product = $productDao->searchById($productId)) {
    echo "<div class='p-6 text-center text-red-600'>Produto não encontrado.</div>";
    include_once "layout_footer.php";
    exit;
}

$supplier = $product->getSupplierId() ? $factory->getSupplierDao()->searchById($product->getSupplierId()) : null;
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">
        <a href="index.php" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&larr; Voltar para Produtos</a>

        <h1 class="text-3xl font-bold mb-4"><?= htmlspecialchars($product->getName()) ?></h1>

        <p class="text-gray-700 mb-2">
            <span class="font-semibold">Preço:</span>
            R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?>
        </p>

        <p class="text-gray-700 mb-2">
            <span class="font-semibold">Quantidade em estoque:</span>
            <?= htmlspecialchars($product->getStock()->getQuantity()) ?>
        </p>

        <p class="text-gray-700 mb-4">
            <span class="font-semibold">Descrição:</span><br>
            <?= nl2br(htmlspecialchars($product->getDescription())) ?>
        </p>

        <?php if ($supplier): ?>
            <hr class="my-6">
            <h2 class="text-xl font-semibold mb-2">Fornecedor</h2>
            <p class="text-gray-700 mb-1"><strong>Nome:</strong> <?= htmlspecialchars($supplier->getName()) ?></p>
            <p class="text-gray-700"><strong>Descrição:</strong> <?= htmlspecialchars($supplier->getDescription()) ?></p>
        <?php endif; ?>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>