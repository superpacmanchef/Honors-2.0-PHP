<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

$dbclass = new database();
$connection = $dbclass->getConnection();


$product = new product($connection);
$stmt = $product->getProductCatagoryPage($_GET["pageNumber"], $_GET["noPerPage"] , $_GET["catagory"]);
$count = $stmt->rowCount();

if ($count > 0) {
    $product_array = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        /**
         * @var string $product_id
         * @var string $name
         * @var string $description
         * @var string $catagory
         * @var string $no_remaining
         */
        extract($row);
        array_push($product_array, $row);
    }
    echo json_encode($product_array);
} else {
    echo json_encode("no product with that id");
}
