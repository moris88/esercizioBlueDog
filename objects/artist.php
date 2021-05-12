<?php
class Artist{

    private $conn;
    private $table_name = "artist";

    public $id;
    public $stage_name;
    public $first_name;
    public $last_name;

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
            $this->stage_name = $row['stage_name'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
        }
    }

    function readOneByName($artist){

        $query = "SELECT * FROM " . $this->table_name. " WHERE stage_name = :artist LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":artist", $artist,PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row>0){
            $this->id = $row['id'];
            $this->stage_name = $row['stage_name'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
        }
    }

    function readStageName($stage_name){

        $query = "SELECT * FROM " . $this->table_name. " WHERE stage_name = :stage_name LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":stage_name", $stage_name,PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row>0){
            $this->id = $row['id'];
            $this->stage_name = $row['stage_name'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
        }
    }
}