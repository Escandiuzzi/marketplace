<?php
interface SupplierDaoInterface {

    public function insert(Supplier $supplier): bool;
    public function remove(Supplier $supplier): bool;
    public function removeById(int $id): bool;
    public function update(Supplier &$supplier): bool;
    public function searchById(int $id): ?Supplier;
    public function searchByEmail(string $email): ?Supplier;
    public function getAll(): Array;
}
?>