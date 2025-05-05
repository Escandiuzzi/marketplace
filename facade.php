<?php
include_once('models/Client.php');
include_once('models/Supplier.php');
include_once('models/Product.php');
include_once('models/Administrator.php');
include_once('models/types/Address.php');
include_once('models/types/CreditCard.php');
include_once('models/types/Stock.php');

include_once('dao/ClientDaoInterface.php');
include_once('dao/DaoFactoryAbstract.php');
include_once('dao/postgres/PostgresDaoFactory.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$factory = new PostgresDaofactory();

?>