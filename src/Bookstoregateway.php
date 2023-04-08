<?php

class Bookstoregateway
{
    private PDO $conn;
    private TokenHandler $token;

    public function __construct(Database $database, TokenHandler $token){
        $this->conn = $database->getConnection();
        $this->token = $token;
    }

    public function generate_token($data) {
        if(!empty($data["name"]) && !empty($data["password"])){
            $sql = "SELECT * FROM users WHERE users.name = :name AND users.password = :password";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name",$data["name"]);
        $stmt->bindValue(":password",$data["password"]);

        $stmt->execute();

        if($stmt->rowCount() < 1){
            return "Invalid Request";
        }
        else{
            $name = $data["name"];

            $headers = array('alg'=>'HS256','typ'=>'JWT');
            $payload = array('username'=>$name, 'exp'=>(time() + 1200));

            $jwt = $this->token->generate_jwt($headers, $payload);

            return $jwt;
         }
        }

        else{
            return "Credentials Required.";        
        }
    }

    public function getBooks(): array 
    {
        $sql = "SELECT b.id,b.title,b.author,b.excerpt,b.genre_id,b.price,b.is_available,genres.name as genre FROM books as b INNER JOIN genres
        ON b.genre_id = genres.id";

        $stmt = $this->conn->query($sql);

        $products = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row){
            
            $row["is_available"] = (bool) $row["is_available"];
            $products[] = $row;
        }

        return $products;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO books (title,author, excerpt, price, genre_id,is_available)
                            VALUES (:title,:author, :excerpt, :price, :genre_id,:is_available)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
        $stmt->bindValue(":author", $data["author"], PDO::PARAM_STR);
        $stmt->bindValue(":excerpt", $data["excerpt"], PDO::PARAM_STR);
        $stmt->bindValue(":price", $data["price"] , PDO::PARAM_INT);
        $stmt->bindValue(":genre_id", $data["genre_id"], PDO::PARAM_INT);
        $stmt->bindValue(":is_available", (bool) ($data["is_available"] ?? false), PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();

    }

    public function getRecord(string $id)
    {
        $sql = "SELECT b.title,b.author,b.excerpt,b.price,b.is_available,genres.name as genre FROM books as b INNER JOIN genres
        ON b.genre_id = genres.id
        WHERE b.id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id",$id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data != false){
            $data["is_available"] = (bool) $data["is_available"]; 
        }
        return $data;
    }

    public function update(array $current, array $new)
    {
        $sql = "UPDATE books
                SET title = :title, author = :author, excerpt = :excerpt, 
                price = :price, genre_id = :genre_id , is_available = :is_available
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":title", $new["title"] ?? $current["title"], PDO::PARAM_STR);
        $stmt->bindValue(":author", $new["author"] ?? $current["author"], PDO::PARAM_STR);
        $stmt->bindValue(":excerpt", $new["excerpt"] ?? $current["excerpt"], PDO::PARAM_STR);
        $stmt->bindValue(":price", $new["price"] ?? $current["price"] , PDO::PARAM_INT);
        $stmt->bindValue(":genre_id", $new["genre_id"] ?? $current["genre_id"], PDO::PARAM_INT);
        $stmt->bindValue(":is_available", (bool) ($current["is_available"] ?? false), PDO::PARAM_BOOL);

        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
        

    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM books WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id",$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function get_genres(){

        $sql = "SELECT * FROM genres ORDER BY id";

        $stmt = $this->conn->query($sql);

        $genres = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row){
            $genres[] = $row;
        }

        return $genres;

    }

    public function get_genre_info($id){
        $sql = "SELECT * FROM genres WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id",$id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function create_genre(array $data){
        $sql = "INSERT INTO genres (name,description) VALUES (:name,:description)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name",$data["name"],PDO::PARAM_STR);
        $stmt->bindValue(":description",$data["description"],PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update_genre(array $current, array $given){
        $sql = "UPDATE genres SET name = :name, description = :description WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name",$given["name"] ?? $current["name"],PDO::PARAM_STR);
        $stmt->bindValue(":description",$given["description"] ?? $current["description"],PDO::PARAM_STR);

        $stmt->bindValue(":id",$current["id"],PDO::PARAM_INT);

        $stmt->execute();
        
        return $stmt->rowCount();

    }

    public function delete_genre($id){
        $sql = "DELETE FROM genres WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id",$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }


}

?>