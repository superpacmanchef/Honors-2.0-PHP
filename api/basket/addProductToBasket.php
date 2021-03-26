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

if(isset($_SESSION["user_id"]))
{
    $stmt = $basket->getBasketIDByUserID($_SESSION["user_id"]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $basket_product->addProductToBasket($row["basket_id"] , $_POST["product_id"] , $_POST["quantity"]);
    echo json_encode($stmt);
}else{
    echo "bums";
}