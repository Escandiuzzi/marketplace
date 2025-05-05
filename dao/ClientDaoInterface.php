<?php
interface ClientDaoInterface {

    public function insert(Client $client): bool;
    public function remove(Client $client): bool;
    public function removeById(int $id): bool;
    public function update(Client &$client): bool;
    public function searchById(int $id): ?Client;
    public function searchByEmail(string $email): ?Client;
    public function getAll(): Array;
}
?>