<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

$dbclass = new database();
$connection = $dbclass->getConnection();

$product = new product($connection);
$stmt = $product->deleteProductByProductID($_POST["product_id"]);
echo json_encode($stmt);