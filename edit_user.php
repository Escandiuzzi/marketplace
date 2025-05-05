<?php
$page_title = "Editar Usuário";
include_once "layout_header.php";
include_once "facade.php";
require_once "auth_admin.php";

$dao = $factory->getClientDao();
$client_id = $_GET['id'] ?? null;
$client = $dao->searchById($client_id);
?>

<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-center">Editar Usuário</h2>
    <form action="actions/admin/client/execute_client_update.php" method="POST" class="space-y-6">
        <input type="hidden" name="id" value="<?= $client->getId() ?>">

        <!-- Personal Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1" for="number">Telefone</label>
                <input type="tel" id="number" name="number"
                    value="<?= htmlspecialchars($client->getNumber()) ?>"
                    pattern="\d{11}" inputmode="numeric"
                    title="O telefone deve conter exatamente 11 dígitos (DDD + número)"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block font-medium mb-1" for="name">Nome</label>
                <input type="text" id="name" name="name"
                    value="<?= htmlspecialchars($client->getName()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block font-medium mb-1" for="email">Email</label>
                <input type="email" id="email" name="email"
                    value="<?= htmlspecialchars($client->getEmail()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block font-medium mb-1" for="password">Senha</label>
                <input type="password" id="password" name="password"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Deixe em branco para manter a senha atual</p>
            </div>
        </div>

        <h3 class="text-lg font-semibold mt-6">Endereço</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block font-medium mb-1" for="street">Rua</label>
                <input type="text" id="street" name="street"
                    value="<?= htmlspecialchars($client->getAddress()->getStreet()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block font-medium mb-1" for="address_number">Número</label>
                <input type="text" id="address_number" name="address_number"
                    inputmode="numeric"
                    value="<?= htmlspecialchars($client->getAddress()->getNumber()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium mb-1" for="complement">Complemento</label>
                <input type="text" id="complement" name="complement"
                    value="<?= htmlspecialchars($client->getAddress()->getComplement()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium mb-1" for="neighborhood">Bairro</label>
                <input type="text" id="neighborhood" name="neighborhood"
                    value="<?= htmlspecialchars($client->getAddress()->getNeighborhood()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium mb-1" for="city">Cidade</label>
                <input type="text" id="city" name="city"
                    value="<?= htmlspecialchars($client->getAddress()->getCity()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium mb-1" for="state">Estado</label>
                <input type="text" id="state" name="state"
                    value="<?= htmlspecialchars($client->getAddress()->getState()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium mb-1" for="zip">CEP</label>
                <input type="text" id="zip" name="zip"
                    value="<?= htmlspecialchars($client->getAddress()->getZip()) ?>"
                    pattern="\d{8}" inputmode="numeric"
                    title="O CEP deve conter exatamente 8 dígitos"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Salvar Alterações
            </button>
        </div>
    </form>
</section>

<?php include_once "layout_footer.php"; ?>