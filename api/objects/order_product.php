<?php


class order_product
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function getProductIDsByOrderID($order_id)
    {
        $stmt = $this->connection->prepare("SELECT * from order_products INNER JOIN products ON order_products.product_id = products.product_id WHERE order_products.order_id = ?");
        $stmt->execute([
            $order_id
        ]);
        return $stmt;
    }

    public function addProductToOrder($order_id , $product_id , $qauntity)
    {
        $stmt = $this->connection->prepare("INSERT into order_products VALUES (?,?,?)");
        $stmt->execute([
            $product_id,
            $order_id,
            $qauntity
        ]);
        return $stmt;
    }

}