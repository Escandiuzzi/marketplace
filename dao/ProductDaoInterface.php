<?php
interface ProductDaoInterface {

    public function insert(Product $product): bool;
    public function remove(Product $product): bool;
    public function removeById(int $id): bool;
    public function update(Product &$product): bool;
    public function searchById(int $id): ?Product;
    public function searchByName(string $name): ?Product;
    public function getAll(): Array;
    public function getBySupplierId(int $supplier_id): Array;
}
?>