<?php

session_start();
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/order.php';
include_once '../objects/order_product.php';
include_once  '../objects/product.php';
include_once  '../objects/basket_product.php';
include_once  '../objects/basket.php';



$dbclass = new database();
$connection = $dbclass->getConnection();

if(isset($_SESSION["user_id"])){
$order  = new order($connection);
$order_product = new order_product($connection);
$product = new product($connection);
$basket = new basket($connection);
$basket_product = new basket_product($connection);

$stmt = $order->getUserOrderIDS();

    if ($stmt->rowCount() > 0) {
        $arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt_order_products = $order_product->getProductIDsByOrderID($row["order_id"]);
            $prod_arr = array();
            while ($row_order_products = $stmt_order_products->fetch(PDO::FETCH_ASSOC)) {
                array_push($prod_arr, $row_order_products);
            }
            array_push($arr, $prod_arr);
        }
        echo json_encode($arr);

    }
}
