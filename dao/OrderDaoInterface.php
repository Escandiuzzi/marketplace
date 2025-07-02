<?php
interface OrderDaoInterface
{

    public function insert(Order $order): int;
    public function remove(Order $order): bool;
    public function removeById(int $id): bool;
    public function update(Order &$order): bool;
    public function searchById(int $id): ?Order;
    public function searchByClientId(int $clientId): ?Order;
    public function getAll(): array;
    public function getAllByClientId(int $clientId): array;
}