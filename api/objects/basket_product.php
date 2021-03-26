<?php


class basket_product
{

    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getBasketProducts($basket_id)
    {
        $stmt = $this->connection->prepare("SELECT * from basket_products INNER JOIN products ON basket_products.product_id = products.product_id WHERE basket_products.basket_id = ?");
        $stmt->bindParam(1 , $basket_id );
        $stmt->execute();
        return $stmt;
    }

    public function addProductToBasket($basket_id , $product_id , $quantity)
    {
        $stmt = $this->connection->prepare("INSERT into basket_products VALUES (?,?,?)");
        $stmt->bindParam(1 ,  $basket_id , PDO::PARAM_STR );
        $stmt->bindParam(2 ,  $product_id , PDO::PARAM_STR );
        $stmt->bindParam(3 , $quantity , PDO::PARAM_INT );
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function removeProductFromBasket($basket_id , $product_id)
    {
        $stmt = $this->connection->prepare("DELETE from basket_products WHERE basket_id = ? AND product_id = ?");
        $stmt->bindParam(1 ,  $basket_id , PDO::PARAM_STR );
        $stmt->bindParam(2 ,  $product_id , PDO::PARAM_STR );
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function removeAllProductsFromBasket($basket_id)
    {
        $stmt = $this->connection->prepare("DELETE from basket_products WHERE basket_id = ?");
        $stmt->bindParam(1 ,  $basket_id , PDO::PARAM_STR );
        $stmt->execute();
        return $stmt->rowCount();
    }
}