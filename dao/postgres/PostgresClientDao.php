<?php

include_once('dao/ClientDaoInterface.php');
include_once('PostgresDao.php');

class PostgresClientDao extends PostgresDao implements ClientDaoInterface
{
    private $table_name = 'clients';

    public function insert(Client $client): bool
    {
        $query = "INSERT INTO " . $this->table_name .
            "(number, name, email, password, street, address_number, complement, neighborhood, city, state, zip, card_number, expiration_date, cvv, holder_name) VALUES" .
            "(:number, :name, :email, :password, :street, :address_number, :complement, :neighborhood, :city, :state, :zip, :card_number, :expiration_date, :cvv, :holder_name)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":number", $client->getNumber());
        $stmt->bindParam(":name", $client->getName());
        $stmt->bindParam(":email", $client->getEmail());
        $stmt->bindParam(":password", md5($client->getPassword()));

        // bind address values
        $stmt->bindParam(":street", $client->getAddress()->getStreet());
        $stmt->bindParam(":address_number", $client->getAddress()->getNumber());
        $stmt->bindParam(":complement", $client->getAddress()->getComplement());
        $stmt->bindParam(":neighborhood", $client->getAddress()->getNeighborhood());
        $stmt->bindParam(":city", $client->getAddress()->getCity());
        $stmt->bindParam(":state", $client->getAddress()->getState());
        $stmt->bindParam(":zip", $client->getAddress()->getZip());

        // bind credit card values
        $stmt->bindParam(":card_number", $client->getCreditCard()->getNumber());
        $stmt->bindParam(":expiration_date", $client->getCreditCard()->getExpirationDate());
        $stmt->bindParam(":cvv", $client->getCreditCard()->getCvv());
        $stmt->bindParam(":holder_name", $client->getCreditCard()->getHolderName());


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

    public function remove(Client $client): bool
    {
        return $this->removeById($client->getId());
    }

    public function update(Client &$client): bool
    {
        $query = "UPDATE " . $this->table_name .
            "(number, name, email, password, street, address_number, complement, neighborhood, city, state, zip, card_number, expiration_date, cvv, holder_name) VALUES" .
            "(:number, :name, :email, :password, :street, :address_number, :complement, :neighborhood, :city, :state, :zip, :card_number, :expiration_date, :cvv, :holder_name)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":number", $client->getNumber());
        $stmt->bindParam(":name", $client->getName());
        $stmt->bindParam(":email", $client->getEmail());
        $stmt->bindParam(":password", md5($client->getPassword()));

        // bind address values
        $stmt->bindParam(":street", $client->getAddress()->getStreet());
        $stmt->bindParam(":address_number", $client->getAddress()->getNumber());
        $stmt->bindParam(":complement", $client->getAddress()->getComplement());
        $stmt->bindParam(":neighborhood", $client->getAddress()->getNeighborhood());
        $stmt->bindParam(":city", $client->getAddress()->getCity());
        $stmt->bindParam(":state", $client->getAddress()->getState());
        $stmt->bindParam(":zip", $client->getAddress()->getZip());

        // bind credit card values
        $stmt->bindParam(":card_number", $client->getCreditCard()->getNumber());
        $stmt->bindParam(":expiration_date", $client->getCreditCard()->getExpirationDate());
        $stmt->bindParam(":cvv", $client->getCreditCard()->getCvv());
        $stmt->bindParam(":holder_name", $client->getCreditCard()->getHolderName());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function searchById(int $id): ?Client
    {
        $client = null;

        $query = "SELECT
                   id, number, name, email, password, street, address_number, complement, neighborhood, city, state, zip, card_number, expiration_date, cvv, holder_name
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
            $client = new Client(
                $row['id'],
                $row['number'],
                $row['email'],
                $row['password'],
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
                new CreditCard(
                    $row['card_number'],
                    $row['expiration_date'],
                    $row['cvv'],
                    $row['holder_name']
                )
            );
        }

        return $client;
    }

    public function searchByEmail(string $email): ?Client
    {
        $client = null;

        $query = "SELECT
                    id, number, name, email, password, street, address_number, complement, neighborhood, city, state, zip, card_number, expiration_date, cvv, holder_name
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
            $client = new Client(
                $row['id'],
                $row['number'],
                $row['email'],
                $row['password'],
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
                new CreditCard(
                    $row['card_number'],
                    $row['expiration_date'],
                    $row['cvv'],
                    $row['holder_name']
                )
            );
        }

        return $client;
    }


    public function getAll(): array
    {
        $clients = array();

        $query = "SELECT
                    id, number, name, email, password, street, address_number, complement, neighborhood, city, state, zip, card_number, expiration_date, cvv, holder_name
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $clients[] = new Client(
                $id,
                $number,
                $email,
                $password,
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
                new CreditCard(
                    $card_number,
                    $expiration_date,
                    $cvv,
                    $holder_name
                )
            );
        }

        return $clients;
    }
}
