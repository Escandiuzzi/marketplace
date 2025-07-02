<?php
include_once('PostgresClientDao.php');
include_once('PostgresSupplierDao.php');
include_once('PostgresProductDao.php');
include_once('PostgresAdministratorDao.php');
include_once('PostgresOrderDao.php');

class PostgresDaofactory extends DaoFactoryAbstract
{
    private $host = "localhost";
    private $db_name = "marketplace";
    private $port = "5432";
    private $username = "postgres";
    private $password = "postgres";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function getClientDao(): ClientDaoInterface
    {
        return new PostgresClientDao($this->getConnection());
    }

    public function getSupplierDao(): SupplierDaoInterface
    {
        return new PostgresSupplierDao($this->getConnection());
    }

    public function getProductDao(): ProductDaoInterface
    {
        return new PostgresProductDao($this->getConnection());
    }
    
    public function getAdministratorDao(): AdministratorDaoInterface
    {
        return new PostgresAdministratorDao($this->getConnection());
    }

     public function getOrderDao(): OrderDaoInterface
    {
        return new PostgresOrderDao($this->getConnection());
    }
}
