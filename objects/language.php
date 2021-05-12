<?php
class Language{

    private $conn;
    private $table_name = "language";

    public $id;
    public $language;

    public function __construct($db){
        $this->conn = $db;
    }

    function readAll(){

        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function readOne($id){

        $query = "SELECT * FROM " . $this->table_name. " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":id", $id,PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row>0){
            $this->id = $row['id'];
            $this->language = $row['language'];
        }
    }

    function readLanguage($lang){

        $query = "SELECT * FROM " . $this->table_name. " WHERE language = :lang LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":lang", $lang,PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row>0){
            $this->id = $row['id'];
            $this->language = $row['language'];
        }
    }
}