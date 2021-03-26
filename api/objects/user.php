<?php
class user
{
    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function login($email , $password)
    {

        $stmt = $this->connection->prepare("SELECT * from users WHERE email = ?");
        $stmt->execute([
            $email
        ]);
        $count = $stmt->rowCount();
        if($count > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash = $row["password"];
            $t = password_verify($password ,$hash);
            if($t){
                $_SESSION["user_id"] = $row["user_id"];
                return true;
            }else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function register($user_id , $email, $password , $firstname , $surname)
    {
        $st = $this->getUserByEmail($email);
        $count = $st->rowCount();

        if($count > 0){
            return false;
        }else{
            $options = [
                'cost' => 10,
            ];
            $password_hash = password_hash($password ,PASSWORD_BCRYPT , $options);
            $stmt = $this->connection->prepare("Insert into users VALUES (?,?,?,?,?)");
            $stmt->execute([
                $user_id,
                $email,
                $password_hash,
                $firstname,
                $surname
            ]);
            return $stmt;
        }
    }

    public function  getUserByID($user_id)
    {
        $stmt = $this->connection->prepare("SELECT * from users WHERE user_id = ?");
        $stmt->execute([
            $user_id
        ]);
        return $stmt;
    }

    private function  getUserByEmail($email)
{
    $stmt = $this->connection->prepare("SELECT * from users WHERE email = ?");
    $stmt->execute([
        $email
    ]);
    return $stmt;
}
}