<?php

header("Content-Type: application/json; charset=UTF-8");

session_start();
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../objects/basket.php';


$dbclass = new database();
$connection = $dbclass->getConnection();

$user = new user($connection);
$basket = new basket($connection);
$user_id = uniqid("" , true);

$stmt = $user->register($user_id , $_POST["email"], $_POST["password"] , $_POST["firstname"] , $_POST["surname"]);
if($stmt == false){
    echo false;
}else {
    $count = $stmt->rowCount();

    if ($count > 0) {
        $stmt = $basket->createBasket($user_id);
        $count = $stmt->rowCount();
        echo json_encode($count);
    } else {
        echo false;
    }
}