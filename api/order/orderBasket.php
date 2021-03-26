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

$order  = new order($connection);
$order_product = new order_product($connection);
$product = new product($connection);
$basket = new basket($connection);
$basket_product = new basket_product($connection);

if(isset($_SESSION["user_id"]))
{
        $stmt = $basket->getBasketIDByUserID();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $basket_id = $row["basket_id"];
        $stmt_basket_product = $basket_product->getBasketProducts($basket_id);
        if($stmt_basket_product->rowCount() > 0) {
            $order_id = uniqid("", true);
            $order->createOrder($order_id);
            while ($row_basket_product = $stmt_basket_product->fetch(PDO::FETCH_ASSOC)) {
                $stmt_order_product = $order_product->addProductToOrder($order_id, $row_basket_product["product_id"], $row_basket_product["quantity"]);
                if ($stmt_order_product->rowCount() > 0) {
                    $stmt_order_product = $product->updateProductRemaining($row_basket_product["product_id"], $row_basket_product["quantity"]);
                }
            }
            $basket_product->removeAllProductsFromBasket($basket_id);
            echo true;
        }else{
            echo false;
        }

}else{
    echo "bumns";
}
