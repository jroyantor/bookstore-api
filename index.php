<?php

declare(strict_types=1);

spl_autoload_register(function($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8;");

$arr = explode('/',$_SERVER["REQUEST_URI"]);

$db = new Database("localhost","db","user","password");
$token = new TokenHandler;
$gateway = new Bookstoregateway($db,$token);

if($arr[1] == "books"){

    $id = $arr[2] ?? null;

    $con = new Bookcontroller($gateway);
    $t = $token->get_bearer_token();

    if(!empty($t) && $token->check_jwt($t) == true){
        $con->processRequest($_SERVER["REQUEST_METHOD"],$id);
        exit;
    }

    else{
        http_response_code(403);
        echo json_encode([
            "message"=>"You are not authorized!"
        ]);
        exit;
    }

}

if($arr[1]=="genres"){
    
    $id = $arr[2] ?? null;

    $con = new Genrecontroller($gateway);
    $t = $token->get_bearer_token();

    if(!empty($t) && $token->check_jwt($t) == true){
        $con->processGenreRequest($_SERVER["REQUEST_METHOD"],$id);
        exit;
    }

    else{
        http_response_code(403);
        echo json_encode([
            "message"=>"You are not authorized!"
        ]);
        exit;
    }
}

if($arr[1]=="token"){
    $data = (array) json_decode(file_get_contents("php://input"),true);
    $token = $gateway->generate_token($data);
    if($token == "Credentials Required."){
        echo json_encode([
            "message" => $token
        ]);
        exit;
    }

    else{
        echo json_encode([
            "token" => $token
        ]);
    }

    exit;
}

else{
    http_response_code(404);
    echo json_encode([
        "message" => "Use your token to get access."
    ]);
    exit;
}

?>