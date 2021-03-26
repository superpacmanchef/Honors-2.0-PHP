<?php


class review
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addReviewToProduct($product_id , $review)
    {
        $stmt = $this->connection->prepare("INSERT into reviews VALUES(?,?,?)");
        $stmt->execute([
            $product_id,
            $_SESSION["user_id"],
            $review
        ]);
        return $stmt;
    }

    public function getUserReviews()
    {
        $stmt = $this->connection->prepare("SELECT * from reviews WHERE user_id = ? ");
        $stmt->execute([
            $_SESSION["user_id"]
        ]);
        return $stmt;
    }

    public function getProductsReviews($product_id)
    {

        $stmt = $this->connection->prepare("SELECT * from reviews WHERE product_id = ? ");
        $stmt->execute([
            $product_id
        ]);
        return $stmt;
    }
}