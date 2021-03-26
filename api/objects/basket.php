<?php


class basket
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getBasketIDByUserID()
    {
        $stmt = $this->connection->prepare("SELECT * FROM basket WHERE user_id = ?");
        $stmt->execute([
            $_SESSION["user_id"]
        ]);
        return $stmt;
    }

    public function createBasket($user_id)
    {
        $basket_id = uniqid("" , true);
        $stmt = $this->connection->prepare("INSERT into basket VALUES(?,?)");
        $stmt->execute([
            $basket_id,
            $user_id
        ]);
        echo json_encode($stmt);
        return $stmt;
    }

}