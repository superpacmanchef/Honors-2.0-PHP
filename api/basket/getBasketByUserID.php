<?php

session_start();
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/basket.php';
include_once '../objects/basket_product.php';
include_once '../objects/product.php';



$dbclass = new database();
$connection = $dbclass->getConnection();

$basket = new basket($connection);
$basket_product = new basket_product($connection);
$product = new product($connection);

if (isset($_SESSION["user_id"])) {
    $stmt = $basket->getBasketIDByUserID();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $basket_product->getBasketProducts($row["basket_id"]);
    $product_array =  array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($product_array , $row);
    }
    echo json_encode($product_array);
}else{
    echo false;
}