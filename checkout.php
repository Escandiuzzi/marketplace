<?php
$page_title = "Checkout";
include_once "layout_header.php";
include_once "facade.php";

$productDao = $factory->getProductDao();
$cart = $_SESSION['cart'] ?? [];

$cart_items = [];

foreach ($cart as $item) {
    $product = $productDao->searchById($item['product_id']);
    if ($product && $product->getStock()->getQuantity() > 0) {
        $quantity = min($item['quantity'], $product->getStock()->getQuantity());
        $price = $product->getStock()->getPrice();
        $total = $quantity * $price;

        $cart_items[] = [
            'product' => $product,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total
        ];
    }
}
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">
        <h1 class="text-2xl font-bold mb-6">Seu Carrinho</h1>

        <?php if (empty($cart_items)): ?>
            <p class="text-gray-600">Seu carrinho está vazio.</p>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($cart_items as $item):
                    $product = $item['product'];
                ?>
                    <div class="flex gap-4 border-b pb-4">
                        <!-- Product Image -->
                        <?php if ($product->getImage()): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>"
                                alt="Imagem do Produto"
                                class="w-24 h-24 object-cover rounded">
                        <?php else: ?>
                            <div class="w-24 h-24 bg-gray-200 flex items-center justify-center text-gray-500 rounded">
                                Sem imagem
                            </div>
                        <?php endif; ?>

                        <!-- Product Details -->
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold"><?= htmlspecialchars($product->getName()) ?></h2>
                            <p class="text-sm text-gray-500">ID: <?= $product->getId() ?></p>
                            <p class="text-sm">Preço unitário: R$ <?= number_format($item['price'], 2, ',', '.') ?></p>
                            <p class="text-sm">Quantidade: <?= $item['quantity'] ?></p>
                            <p class="text-sm font-semibold text-gray-700">Subtotal: R$ <?= number_format($item['total'], 2, ',', '.') ?></p>

                            <form action="actions/cart/remove_from_cart.php" method="POST" class="mt-2">
                                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                                <button type="submit" class="text-red-600 hover:underline text-sm">Remover</button>
                            </form>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <div class="mt-8 border-t pt-4 text-right">
                <p class="text-xl font-bold text-gray-800">
                    Total: R$ <span id="cart-total">0,00</span>
                </p>

                <form action="actions/cart/confirm_purchase.php" method="POST" class="mt-4">
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Finalizar Compra
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('./actions/cart/cart_total.php')
            .then(response => response.json())
            .then(data => {
                const totalElement = document.getElementById('cart-total');
                if (totalElement && data.cart_total !== undefined) {
                    totalElement.textContent = data.cart_total;
                }
            })
            .catch(error => console.error('Erro ao buscar o total do carrinho:', error));
    });
</script>

<?php include_once "layout_footer.php"; ?>