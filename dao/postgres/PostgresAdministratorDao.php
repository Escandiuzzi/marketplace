<?php
include_once('PostgresDao.php');

class PostgresAdministratorDao extends PostgresDao implements AdministratorDaoInterface
{
    private $table_name = 'admins';

    public function insert(Administrator $administrator): bool
    {
        $query = "INSERT INTO " . $this->table_name .
            "(name, email, password) VALUES" .
            "(:name, :email, :password)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":name", $administrator->getName());
        $stmt->bindParam(":email", $administrator->getEmail());
        $stmt->bindParam(":password", md5($administrator->getPassword()));

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

    public function remove(Administrator $administrator): bool
    {
        return $this->removeById($administrator->getId());
    }

    public function update(Administrator &$administrator): bool
    {
        $query = "UPDATE " . $this->table_name .
            "(name, email, password) VALUES" .
            "(:name, :email, :password)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":name", $administrator->getName());
        $stmt->bindParam(":email", $administrator->getEmail());
        $stmt->bindParam(":password", md5($administrator->getPassword()));

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function searchById(int $id): ?Administrator
    {
        $administrator = null;

        $query = "SELECT
                    id, name, email, password
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
            $administrator = new Administrator(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['password']
            );
        }

        return $administrator;
    }

    public function searchByEmail(string $email): ?Administrator
    {
        $administrator = null;

        $query = "SELECT
                    id, name, email, password
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
            $administrator = new Administrator(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['password']
            );
        }

        return $administrator;
    }
}
