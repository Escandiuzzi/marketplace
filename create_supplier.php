<?php
$page_title = "Criar Fornecedor";
include_once "layout_header.php";
?>

<section class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-3xl">
        <h2 class="text-2xl font-semibold mb-6 text-center">Cadastrar Novo Fornecedor</h2>

        <form action="./actions/admin/supplier/execute_supplier_create.php" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="number" class="block font-medium text-gray-700 mb-1">Número</label>
                    <input type="number" id="number" name="number" max="99999999999" name="number" id="number" required
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="name" class="block font-medium text-gray-700 mb-1">Nome</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="description" id="description" rows="3" required
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="street" class="block font-medium text-gray-700 mb-1">Rua</label>
                    <input type="text" name="street" id="street"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="address_number" class="block font-medium text-gray-700 mb-1">Número do Endereço</label>
                    <input type="text" name="address_number" id="address_number"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="complement" class="block font-medium text-gray-700 mb-1">Complemento</label>
                    <input type="text" name="complement" id="complement"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="neighborhood" class="block font-medium text-gray-700 mb-1">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhood"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="city" class="block font-medium text-gray-700 mb-1">Cidade</label>
                    <input type="text" name="city" id="city"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="state" class="block font-medium text-gray-700 mb-1">Estado</label>
                    <input type="text" name="state" id="state"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="zip" class="block font-medium text-gray-700 mb-1">CEP</label>
                    <input type="text" name="zip" id="zip"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="text-center mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Cadastrar Fornecedor
                </button>
            </div>
        </form>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>
