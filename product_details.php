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
        <a href="index.php" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
            &larr; Voltar para Produtos
        </a>

        <!-- Product Image -->
        <?php if ($product->getImage()): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>"
                alt="Imagem do Produto"
                class="w-full h-64 object-cover rounded mb-6">
        <?php else: ?>
            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 mb-6 rounded">
                Sem imagem
            </div>
        <?php endif; ?>

        <!-- Product Name and ID -->
        <h1 class="text-3xl font-bold mb-1"><?= htmlspecialchars($product->getName()) ?></h1>
        <p class="text-sm text-gray-500 mb-4">ID do Produto: <?= htmlspecialchars($product->getId()) ?></p>

        <!-- Price -->
        <p class="text-gray-700 mb-2">
            <span class="font-semibold">Preço:</span>
            R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?>
        </p>

        <!-- Quantity -->
        <p class="text-gray-700 mb-2">
            <span class="font-semibold">Quantidade em estoque:</span>
            <?= htmlspecialchars($product->getStock()->getQuantity()) ?>
        </p>

        <!-- Description -->
        <p class="text-gray-700 mb-4">
            <span class="font-semibold">Descrição:</span><br>
            <?= nl2br(htmlspecialchars($product->getDescription())) ?>
        </p>

        <!-- Supplier -->
        <?php if ($supplier): ?>
            <hr class="my-6">
            <h2 class="text-xl font-semibold mb-2">Fornecedor</h2>
            <p class="text-gray-700 mb-1"><strong>Nome:</strong> <?= htmlspecialchars($supplier->getName()) ?></p>
            <p class="text-gray-700"><strong>Descrição:</strong> <?= htmlspecialchars($supplier->getDescription()) ?></p>
        <?php endif; ?>

        <!-- Add to cart -->
        <?php if ($product->getStock()->getQuantity() > 0): ?>
            <form method="POST" action="actions/cart/add_to_cart.php" class="mt-6 space-y-4">
                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product->getStock()->getQuantity() ?>"
                        class="w-24 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                    Adicionar ao carrinho
                </button>
            </form>

        <?php else: ?>
            <p class="mt-6 text-red-600 font-semibold">Produto indisponível no momento.</p>
        <?php endif; ?>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const quantityInput = document.getElementById("quantity");
        const maxQuantity = parseInt(quantityInput.max, 10);

        quantityInput.addEventListener("input", function() {
            const errorMsgId = "quantity-error-message";
            let errorEl = document.getElementById(errorMsgId);

            if (parseInt(this.value, 10) > maxQuantity) {
                if (!errorEl) {
                    errorEl = document.createElement("p");
                    errorEl.id = errorMsgId;
                    errorEl.className = "text-red-600 text-sm mt-1";
                    this.parentNode.appendChild(errorEl);
                }
                errorEl.textContent = `Quantidade máxima disponível: ${maxQuantity}`;
                this.value = maxQuantity;
            } else if (errorEl) {
                errorEl.remove();
            }
        });
    });
</script>


<?php include_once "layout_footer.php"; ?>