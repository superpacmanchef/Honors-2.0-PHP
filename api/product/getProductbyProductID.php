<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

$dbclass = new database();
$connection = $dbclass->getConnection();


$product = new product($connection);
$stmt = $product->getProductByProjectID($_GET["product_id"]);
$count = $stmt->rowCount();
if ($count > 0) {
    $product_array = array();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
} else {
    echo json_encode("no product page");
}
