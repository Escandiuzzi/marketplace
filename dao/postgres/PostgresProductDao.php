<?php

include_once('PostgresDao.php');

class PostgresProductDao extends PostgresDao implements ProductDaoInterface
{
    private $table_name = 'products';

    public function insert(Product $product): bool
    {
        $query = "INSERT INTO " . $this->table_name .
            "(supplier_id, name, description, quantity, price, image) VALUES" .
            "(:supplier_id, :name, :description, :quantity, :price, :image)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":supplier_id", $product->getSupplierId());
        $stmt->bindParam(":name", $product->getName());
        $stmt->bindParam(":description", $product->getDescription());
        $stmt->bindParam(":quantity", $product->getStock()->getQuantity());
        $stmt->bindParam(":price", $product->getStock()->getPrice());
        $stmt->bindParam(":image", $product->getImage(), PDO::PARAM_LOB);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function removeById(int $id): bool
    {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove(Product $product): bool
    {
        return $this->removeById($product->getId());
    }

    public function update(Product &$product): bool
    {
        $query = "UPDATE " . $this->table_name . " SET 
            supplier_id = :supplier_id,
            name = :name,
            description = :description,
            quantity = :quantity,
            price = :price
          WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":id", $product->getId());
        $stmt->bindParam(":supplier_id", $product->getSupplierId());
        $stmt->bindParam(":name", $product->getName());
        $stmt->bindParam(":description", $product->getDescription());
        $stmt->bindParam(":quantity", $product->getStock()->getQuantity());
        $stmt->bindParam(":price", $product->getStock()->getPrice());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function searchById(int $id): ?Product
    {
        $user = null;

        $query = "SELECT
                   supplier_id, name, description, quantity, price
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $product = new Product(
                $id,
                $row['supplier_id'],
                $row['name'],
                $row['description'],
                '',
                new Stock(
                    $row['quantity'],
                    $row['price']
                )
            );
        }

        return $product;
    }

    public function searchByName(string $name): ?Product
    {
        $product = null;

        $query = "SELECT
                    supplier_id, name, description, quantity, price
                FROM
                    " . $this->table_name . "
                WHERE
                    name = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $product = new Product(
                $row['id'],
                $row['supplier_id'],
                $row['name'],
                $row['description'],
                '',
                new Stock(
                    $row['quantity'],
                    $row['price']
                )
            );
        }

        return $product;
    }

    public function getAll(): array
    {
        $products = array();

        $query = "SELECT
                    id, supplier_id, name, description, quantity, price, image
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $products[] = new Product(
                $row['id'],
                $row['supplier_id'],
                $row['name'],
                $row['description'],
                $row['image'],
                new Stock(
                    $row['quantity'],
                    $row['price']
                )
            );
        }

        return $products;
    }

    public function getBySupplierId(int $supplier_id): array
    {
        $products = array();

        $query = "SELECT
                    id, name, description, quantity, price, image
                FROM
                    " . $this->table_name .
            " WHERE supplier_id = :supplier_id ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $image = is_resource($row['image']) ? stream_get_contents($row['image']) : null;
            $products[] = new Product(
                $row['id'],
                $supplier_id,
                $row['name'],
                $row['description'],
                $image,
                new Stock(
                    $row['quantity'],
                    $row['price']
                )
            );
        }

        return $products;
    }
}
