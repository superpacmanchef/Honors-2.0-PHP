<?php

header("Content-Type: application/json; charset=UTF-8");

session_start();
include_once '../config/database.php';
include_once '../objects/review.php';

$dbclass = new database();
$connection = $dbclass->getConnection();

$review = new review($connection);
if (isset($_SESSION["user_id"])) {

    $stmt = $review->addReviewToProduct($_POST["product_id"] , $_POST["review"]);
    if($stmt->rowCount() > 0)
    {
        echo true;
    }
    else{
        echo false;
    }

}