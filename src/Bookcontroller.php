<?php 

class Bookcontroller 
{
    private $gway;

    public function __construct(Bookstoregateway $gateway){
        $this->gway = $gateway;
    }

    public function processRequest(string $method, ?string $id): void    
    {
        if($id){
            $this->processResourceRequest($method,$id);
        } else{
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void{
        $product = $this->gway->getRecord($id);

        if(!$product){
            http_response_code(404);
            echo json_encode(["message" => "Specified book is not available."]);
            return;
        }

        switch($method){
            case "GET":
                echo json_encode($product);
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"),true);

                $errors = $this->getValidationErrors($data,false);

                if(! empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gway->update($product,$data);

                echo json_encode([
                    "message" => "Book $id updated.",
                    "rows" => "$rows rows affected"
                ]);

                break;
            case "DELETE":
                $rows = $this->gway->delete($id);

                echo json_encode([
                    "message" => "Book $id deleted",
                    "rows" => "$rows affected"
                ]);
                break;

            default:
              http_response_code(405);
              header("Allow: GET,PATCH,DELETE");
              break;
        }
    }

    private function processCollectionRequest(string $method): void{

        switch($method){
            case "GET":
                echo json_encode($this->gway->getBooks());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"),true);

                $errors = $this->getValidationErrors($data);

                if(! empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gway->create($data);

                http_response_code(201);

                echo json_encode([
                    "message" => "New book info added",
                    "id" => $id
                ]);

                break;
            
            default:
              http_response_code(405);
              header("Allow: GET,POST");
        }
    
    }

    public function getValidationErrors(array $data,  bool $is_new = true): array 
    {
        $errors = [];

        if ($is_new && empty($data["title"])){
            $errors[] = "Book title is required";
        }

        if ($is_new && empty($data["author"])){
            $errors[] = "Author name is required";
        }

        if ($is_new && empty($data["excerpt"])){
            $errors[] = "Book excerpt is required";
        }

        if(array_key_exists("price",$data)){
            if(filter_var($data["price"],FILTER_VALIDATE_INT) === false){
                $errors[] = "Price must be an integer";
            }
        }

        if(array_key_exists("genre_id",$data)){
            if(filter_var($data["genre_id"],FILTER_VALIDATE_INT) === false){
                $errors[] = "Genre id must be an integer";
            }
        }

        return $errors;
    }
}

?>