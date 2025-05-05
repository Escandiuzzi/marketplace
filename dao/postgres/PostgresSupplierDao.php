<?php

include_once('PostgresDao.php');

class PostgresSupplierDao extends PostgresDao implements SupplierDaoInterface
{
    private $table_name = 'suppliers';

    public function insert(Supplier $supplier): bool
    {
        $query = "INSERT INTO " . $this->table_name .
            "(number, name, street, address_number, complement, neighborhood, city, state, zip, description) VALUES" .
            "(:number, :name, :street, :address_number, :complement, :neighborhood, :city, :state, :zip, :description)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":number", $supplier->getNumber());
        $stmt->bindParam(":name", $supplier->getName());
        $stmt->bindParam(":description", $supplier->getDescription());

        // bind address values
        $stmt->bindParam(":street", $supplier->getAddress()->getStreet());
        $stmt->bindParam(":address_number", $supplier->getAddress()->getNumber());
        $stmt->bindParam(":complement", $supplier->getAddress()->getComplement());
        $stmt->bindParam(":neighborhood", $supplier->getAddress()->getNeighborhood());
        $stmt->bindParam(":city", $supplier->getAddress()->getCity());
        $stmt->bindParam(":state", $supplier->getAddress()->getState());
        $stmt->bindParam(":zip", $supplier->getAddress()->getZip());

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

    public function remove(Supplier $supplier): bool
    {
        return $this->removeById($supplier->getId());
    }

    public function update(Supplier &$client): bool
    {
        $query = "UPDATE " . $this->table_name . " SET
        number = :number,
        name = :name,
        street = :street,
        address_number = :address_number,
        complement = :complement,
        neighborhood = :neighborhood,
        city = :city,
        state = :state,
        zip = :zip,
        description = :description
      WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":id", $client->getId());
        $stmt->bindParam(":number", $client->getNumber());
        $stmt->bindParam(":name", $client->getName());
        $stmt->bindParam(":description", $client->getDescription());

        // bind address values
        $stmt->bindParam(":street", $client->getAddress()->getStreet());
        $stmt->bindParam(":address_number", $client->getAddress()->getNumber());
        $stmt->bindParam(":complement", $client->getAddress()->getComplement());
        $stmt->bindParam(":neighborhood", $client->getAddress()->getNeighborhood());
        $stmt->bindParam(":city", $client->getAddress()->getCity());
        $stmt->bindParam(":state", $client->getAddress()->getState());
        $stmt->bindParam(":zip", $client->getAddress()->getZip());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function searchById(int $id): ?Supplier
    {
        $supplier = null;

        $query = "SELECT
                  number, name, street, address_number, complement, neighborhood, city, state, zip, description
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
            $supplier = new Supplier(
                $id,
                $row['number'],
                $row['name'],
                new Address(
                    $row['street'],
                    $row['address_number'],
                    $row['complement'],
                    $row['neighborhood'],
                    $row['city'],
                    $row['state'],
                    $row['zip']
                ),
                $row['description']
            );
        }

        return $supplier;
    }

    public function searchByEmail(string $email): ?Supplier
    {
        $supplier = null;

        $query = "SELECT
                      number, name, street, address_number, complement, neighborhood, city, state, zip, description
                FROM
                    " . $this->table_name . "
                WHERE
                    email = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $supplier = new Supplier(
                $row['id'],
                $row['number'],
                $row['name'],
                new Address(
                    $row['street'],
                    $row['address_number'],
                    $row['complement'],
                    $row['neighborhood'],
                    $row['city'],
                    $row['state'],
                    $row['zip']
                ),
                $row['description']
            );
        }

        return $supplier;
    }


    public function getAll(): array
    {
        $suppliers = array();

        $query = "SELECT
                    id, number, name, street, address_number, complement, neighborhood, city, state, zip, description
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $suppliers[] = new Supplier(
                $id,
                $number,
                $name,
                new Address(
                    $street,
                    $address_number,
                    $complement,
                    $neighborhood,
                    $city,
                    $state,
                    $zip
                ),
                $description
            );
        }

        return $suppliers;
    }
}
