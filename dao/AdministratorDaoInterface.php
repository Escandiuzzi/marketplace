<?php
interface AdministratorDaoInterface
{
    public function insert(Administrator $admin): bool;
    public function remove(Administrator $administrator): bool;
    public function removeById(int $id): bool;
    public function update(Administrator &$administrator): bool;
    public function searchById(int $id): ?Administrator;
    public function searchByEmail(string $email): ?Administrator;
}
