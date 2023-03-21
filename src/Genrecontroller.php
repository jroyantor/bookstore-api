<?php

class Genrecontroller{
    private $gway;

    public function __construct(Bookstoregateway $gateway){
        $this->gway = $gateway;
    }

    public function processGenreRequest(string $method, ?string $id){

        if($id){
            $this->processResourceRequest($method,$id);
        }
        else{
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest($method,$id){
        $genre = $this->gway->get_genre_info($id);

        if(!$genre){
            http_response_code(404);
            echo json_encode(["message" => "Specified genre info is not available."]);
            return;
        }

        switch($method){
            case "GET":
                echo json_encode($genre);
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"),true);

                $errors = $this->validationErrors($data,false);

                if(! empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gway->update_genre($genre,$data);

                echo json_encode([
                    "message" => "Genre $id updated.",
                    "rows" => "$rows rows changed"
                ]);

                break;
            case "DELETE":
                $rows = $this->gway->delete_genre($id);

                echo json_encode([
                    "message" => "Genre $id deleted",
                    "rows" => "$rows rows changed"
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET,PATCH,DELETE");
                break;
            
        }
    }

    private function processCollectionRequest($method){

        switch($method){
            case "GET":
                echo json_encode($this->gway->get_genres());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"),true);

                $errors = $this->validationErrors($data);

                if(! empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gway->create_genre($data);

                http_response_code(201);

                echo json_encode([
                    "message" => "New genre info added",
                    "id" => $id
                ]);

                break;
                
                default:
                    http_response_code(405);
                    header("Allow: GET,POST");
                    break;
         }
    }

    public function validationErrors(array $data, bool $is_new = true){
        $errors = [];

        if ($is_new && empty($data["name"])){
            $errors[] = "Genre name is required";
        }

        if ($is_new && empty($data["description"])){
            $errors[] = "Genre description is required";
        }

        return $errors;
    }
}

?>