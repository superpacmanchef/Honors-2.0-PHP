<?php

header("Content-Type: application/json; charset=UTF-8");

session_start();
include_once '../config/database.php';
include_once '../objects/review.php';

$dbclass = new database();
$connection = $dbclass->getConnection();

$review = new review($connection);
$stmt = $review->getProductsReviews($_GET["product_id"]);
$review_array = array();
while($row = $stmt-> fetch(PDO::FETCH_ASSOC))
{
    array_push($review_array , $row);
}
echo json_encode($review_array);
