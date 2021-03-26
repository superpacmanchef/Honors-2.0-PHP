<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
include_once '../config/database.php';
include_once '../objects/user.php';

$dbclass = new database();
$connection = $dbclass->getConnection();

$user = new user($connection);
$stmt = $user->login($_POST["email"] , $_POST["password"]);

if($stmt)
{
   echo true;

}else{
    echo false;
}
