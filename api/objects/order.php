<?php


class order
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getUserOrderIDS()
    {
        $stmt = $this->connection->prepare("SELECT * from orders WHERE user_id = ?");
        $stmt->execute([
            $_SESSION["user_id"]
        ]);
        return $stmt;
    }

    public function  createOrder($order_id)
    {
        $stmt = $this->connection->prepare("INSERT into orders VALUES (?,?)");
        $stmt->execute([
            $order_id,
            $_SESSION["user_id"]
        ]);
        return $stmt;
    }
}