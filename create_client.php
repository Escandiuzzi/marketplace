<?php
$page_title = "Novo Usuário";
include_once "layout_header.php";
?>
<section class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-2xl">
        <h2 class="text-2xl font-semibold text-center mb-6">Cadastro de Novo Usuário</h2>

        <form action="./actions/login/execute_create_client.php" method="POST" class="space-y-6">
            <!-- Personal Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Nome completo</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="number" class="block text-gray-700 font-medium mb-1">Telefone</label>
                    <input type="text" name="number" id="number" required pattern="\d{11}" maxlength="11" title="Informe 11 dígitos" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label for="password" class="block text-gray-700 font-medium mb-1">Senha</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <!-- Address Info -->
            <h3 class="text-lg font-semibold text-gray-800 mt-4">Endereço</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="street" class="block text-gray-700 font-medium mb-1">Rua</label>
                    <input type="text" name="street" id="street" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="address_number" class="block text-gray-700 font-medium mb-1">Número</label>
                    <input type="text" name="address_number" id="address_number" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="complement" class="block text-gray-700 font-medium mb-1">Complemento</label>
                    <input type="text" name="complement" id="complement" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="neighborhood" class="block text-gray-700 font-medium mb-1">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhood" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="city" class="block text-gray-700 font-medium mb-1">Cidade</label>
                    <input type="text" name="city" id="city" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="state" class="block text-gray-700 font-medium mb-1">Estado</label>
                    <input type="text" name="state" id="state" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="zip" class="block text-gray-700 font-medium mb-1">CEP</label>
                    <input type="text" name="zip" id="zip" pattern="\d{8}" maxlength="8" title="Informe 8 dígitos" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <!-- Payment Info -->
            <h3 class="text-lg font-semibold text-gray-800 mt-4">Informações de Pagamento</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="card_number" class="block text-gray-700 font-medium mb-1">Número do Cartão</label>
                    <input type="text" name="card_number" id="card_number" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="expiration_date" class="block text-gray-700 font-medium mb-1">Validade (MM/AA)</label>
                    <input type="text" name="expiration_date" id="expiration_date" placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/\d{2}" title="Formato MM/AA" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label for="cvv" class="block text-gray-700 font-medium mb-1">CVV</label>
                    <input type="text" name="cvv" id="cvv" pattern="\d{3}" maxlength="3" title="Informe 3 dígitos" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label for="holder_name" class="block text-gray-700 font-medium mb-1">Nome do Titular</label>
                    <input type="text" name="holder_name" id="holder_name" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition duration-200">
                    Criar Conta
                </button>
            </div>
            <div class="text-center">
                <a href="login.php" class="text-blue-600 hover:underline">Voltar para o Login</a>
            </div>
        </form>
    </div>
</section>

<script>
    document.getElementById('number').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 11);
    });
    document.getElementById('zip').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 8);
    });
    document.getElementById('cvv').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
    });
</script>

<?php
include_once "layout_footer.php";
?>