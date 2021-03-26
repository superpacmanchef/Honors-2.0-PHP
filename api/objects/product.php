<?php


class product
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function getProductByProjectID($projectID)
    {
        $stmt = $this->connection->prepare("SELECT * from products WHERE product_id = ? ");
        $stmt->execute([
            $projectID
        ]);
        return $stmt;
    }

    public function getProductPage($pageNumber , $noPerPage){
        $offset = $noPerPage * $pageNumber;
        $stmt = $this->connection->prepare("SELECT * from products LIMIT ? OFFSET ?");
        $stmt->bindParam(1 , $noPerPage , PDO::PARAM_INT);
        $stmt->bindParam(2, $offset , PDO::PARAM_INT );
        $stmt->execute();
        return $stmt;
    }

    public function getProductCatagoryPage($pageNumber , $noPerPage , $catagory){
        $offset = $noPerPage * $pageNumber;
        $stmt = $this->connection->prepare("SELECT * from products WHERE catagory = ? LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $catagory);
        $stmt->bindParam(2 , $noPerPage , PDO::PARAM_INT);
        $stmt->bindParam(3, $offset , PDO::PARAM_INT );
        $stmt->execute();
        return $stmt;
    }

    public function deleteProductByProductID($product_id)
    {   $str = (string) $product_id;
        $stmt = $this->connection->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bindParam(1,$str , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function updateProductRemaining($product_id , $no_bought)
    {   $stmt_products_remaining = $this->getNumberOfProductsRemaining($product_id);
        $row = $stmt_products_remaining->fetch();
        $no_remainig = $row["#_remaining"];
        $new_remaining = $no_remainig - $no_bought;
        $stmt_update = $this->connection->prepare("UPDATE products SET `#_remaining` = ? WHERE product_id = ?");
        $stmt_update->execute([$new_remaining , $product_id]);
        return $stmt_update;
    }

    public function getNumberOfProductsRemaining($product_id)
    {
        $stmt = $this->connection->prepare("SELECT `#_remaining` from products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt;
    }

}