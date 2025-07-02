<?php
include_once('PostgresDao.php');

class PostgresOrderDao extends PostgresDao implements OrderDaoInterface
{
    private string $orderTable = 'orders';
    private string $itemTable = 'order_items';

    public function insert(Order $order): int
    {
        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO {$this->orderTable} 
                (client_id, total, status) 
                VALUES (:client_id, :total, :status)
                RETURNING id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":client_id", $order->getClientId());
            $stmt->bindValue(":total", $order->getTotal());
            $stmt->bindValue(":status", $order->getStatus()->value);

            $stmt->execute();
            $orderId = $stmt->fetchColumn();

            foreach ($order->getProducts() as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                $itemStmt = $this->conn->prepare("
                    INSERT INTO {$this->itemTable} (order_id, product_id, quantity, price)
                    VALUES (:order_id, :product_id, :quantity, :price)
                ");
                $itemStmt->bindValue(":order_id", $orderId);
                $itemStmt->bindValue(":product_id", $product_id);
                $itemStmt->bindValue(":quantity", $quantity);
                $itemStmt->bindValue(":price", $price);
                $itemStmt->execute();

                $updateStockStmt = $this->conn->prepare("
                    UPDATE products SET quantity = quantity - :quantity
                    WHERE id = :product_id AND quantity >= :quantity
                ");
                $updateStockStmt->bindValue(":quantity", $quantity);
                $updateStockStmt->bindValue(":product_id", $product_id);
            }

            $this->conn->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Erro ao inserir pedido: " . $e->getMessage());
            return 0;
        }
    }

    public function remove(Order $order): bool
    {
        return $this->removeById($order->getId());
    }

    public function removeById(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->orderTable} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update(Order &$order): bool
    {
        $query = "UPDATE {$this->orderTable}
            SET shipping_date = :shipping_date, status = :status
            WHERE id = :id";

        $shippingDate = null;

        if ($order->getShippingDate() !== null) {
            $shippingDate = $order->getShippingDate()->format('Y-m-d');
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $order->getId());
        $stmt->bindValue(":shipping_date", $shippingDate);
        $stmt->bindValue(":status", $order->getStatus()->value);

        return $stmt->execute();
    }

    public function searchById(int $id): ?Order
    {
        $query = "SELECT * FROM {$this->orderTable} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $orderRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$orderRow) {
            return null;
        }

        $itemsQuery = "SELECT product_id, quantity, price FROM {$this->itemTable} WHERE order_id = :order_id";
        $itemStmt = $this->conn->prepare($itemsQuery);
        $itemStmt->bindParam(':order_id', $id);
        $itemStmt->execute();
        $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

        $factory = new PostgresDaoFactory();
        $productDao = $factory->getProductDao();

        $products = [];

        foreach ($items as $item) {
            $product = $productDao->searchById($item['product_id']);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => (int)$item['quantity'],
                    'price' => (int)$item['price'],
                    'total' => (int)$item['price'] * (int)$item['quantity']
                ];
            }
        }

        $shippingDate = null;

        if (!empty($orderRow['shipping_date'])) {
            $shippingDate = new DateTime($orderRow['shipping_date']);
        }

        return new Order(
            (int)$orderRow['id'],
            (int)$orderRow['client_id'],
            $products,
            (int)$orderRow['total'],
            new DateTime($orderRow['created_at']),
            $shippingDate,
            Status::from($orderRow['status'])
        );
    }

    public function searchByClientId(int $clientId): ?Order
    {
        $query = "SELECT * FROM orders WHERE client_id = :client_id ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $clientId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $orderId = $row['id'];

        $productQuery = "SELECT product_id, quantity FROM order_products WHERE order_id = :order_id";
        $productStmt = $this->conn->prepare($productQuery);
        $productStmt->bindParam(':order_id', $orderId);
        $productStmt->execute();

        $products = [];
        $productDao = new PostgresProductDao($this->conn);

        while ($prodRow = $productStmt->fetch(PDO::FETCH_ASSOC)) {
            $product = $productDao->searchById($prodRow['product_id']);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $prodRow['quantity'],
                ];
            }
        }

        $order = new Order(
            (int)$row['id'],
            (int)$row['client_id'],
            $products,
            (int)$row['total'],
            new DateTime($row['created_at']),
            new DateTime($row['shipping_date']),
            Status::from($row['status'])
        );

        return $order;
    }

    public function getAll(): array
    {
        $orders = [];

        $query = "
        SELECT o.*, op.product_id, op.quantity, op.price
        FROM orders o
        JOIN order_items op ON o.id = op.order_id
        ORDER BY o.created_at DESC
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedOrders = [];

        foreach ($rows as $row) {
            $orderId = $row['id'];

            if (!isset($groupedOrders[$orderId])) {
                $groupedOrders[$orderId] = [
                    'order_data' => $row,
                    'products' => []
                ];
            }

            $groupedOrders[$orderId]['products'][] = [
                'product_id' => $row['product_id'],
                'quantity' => (int) $row['quantity'],
                'price' => (int) $row['price']
            ];
        }

        foreach ($groupedOrders as $group) {
            $row = $group['order_data'];
            $products = [];

            $factory = new PostgresDaoFactory();
            $productDao = $factory->getProductDao();

            foreach ($group['products'] as $item) {
                $product = $productDao->searchById($item['product_id']);
                if ($product) {
                    $products[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['price'] * $item['quantity']
                    ];
                }
            }

            $orders[] = new Order(
                (int) $row['id'],
                (int) $row['client_id'],
                $products,
                (int) $row['total'],
                new DateTime($row['created_at']),
                $row['shipping_date'] ? new DateTime($row['shipping_date']) : new DateTime(), // default fallback
                Status::from($row['status'])
            );
        }

        return $orders;
    }

    public function getAllByClientId(int $clientId): array
    {
        $orders = [];

        $query = "
        SELECT o.*, op.product_id, op.quantity, op.price
        FROM orders o
        JOIN order_items op ON o.id = op.order_id
        WHERE o.client_id = :client_id
        ORDER BY o.created_at DESC
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedOrders = [];

        foreach ($rows as $row) {
            $orderId = $row['id'];

            if (!isset($groupedOrders[$orderId])) {
                $groupedOrders[$orderId] = [
                    'order_data' => $row,
                    'products' => []
                ];
            }

            $groupedOrders[$orderId]['products'][] = [
                'product_id' => $row['product_id'],
                'quantity' => (int) $row['quantity'],
                'price' => (int) $row['price']
            ];
        }

        foreach ($groupedOrders as $group) {
            $row = $group['order_data'];
            $products = [];

            $factory = new PostgresDaoFactory();
            $productDao = $factory->getProductDao();

            foreach ($group['products'] as $item) {
                $product = $productDao->searchById($item['product_id']);
                if ($product) {
                    $products[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['price'] * $item['quantity']
                    ];
                }
            }

            $orders[] = new Order(
                (int) $row['id'],
                (int) $row['client_id'],
                $products,
                (int) $row['total'],
                new DateTime($row['created_at']),
                $row['shipping_date'] ? new DateTime($row['shipping_date']) : new DateTime(), // default fallback
                Status::from($row['status'])
            );
        }

        return $orders;
    }
}
