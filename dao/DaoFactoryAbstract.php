<?php

include_once('ClientDaoInterface.php');
include_once('SupplierDaoInterface.php');
include_once('ProductDaoInterface.php');
include_once('AdministratorDaoInterface.php');
include_once('OrderDaoInterface.php');

abstract class DaoFactoryAbstract {

    protected abstract function getConnection();

    public abstract function getClientDao(): ClientDaoInterface;
    public abstract function getSupplierDao(): SupplierDaoInterface;
    public abstract function getProductDao(): ProductDaoInterface;
    public abstract function getAdministratorDao(): AdministratorDaoInterface;
    public abstract function getOrderDao(): OrderDaoInterface;
}
?>