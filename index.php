<?php

declare(strict_types=1);

spl_autoload_register(function($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8;");

$arr = explode('/',$_SERVER["REQUEST_URI"]);

if($arr[1] != "books"){

    if($arr[1]=="genres"){
        echo json_encode([
            "name" => "Fiction",
            "description" => "About fiction",
            "id" => $arr[2] ?? 1
        ]);
        exit;
    }

    else{
        http_response_code(404);
        exit;
    }
}

$id = $arr[2] ?? null;

$db = new Database("host","db","user","password");

$gateway = new Bookstoregateway($db);

$con = new Bookcontroller($gateway);

$con->processRequest($_SERVER["REQUEST_METHOD"],$id);

?>