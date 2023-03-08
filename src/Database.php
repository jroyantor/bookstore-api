<?php
class Database
{
    private string $host;
    private string $name;
    private string $user;
    private string $password;

    public function __construct($host,$name,$user,$password){
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
    }

    public function getConnection(): PDO
    {
        $db = "mysql:host={$this->host};dbname={$this->name}";

        $pdo = new PDO($db, $this->user,$this->password,[
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}

?>