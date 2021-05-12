<?php
class Sales{

    private $conn;
    private $table_name = "sales";

    public $id;
    public $sale_datetime;
    public $number_sales;

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
            $this->sale_datetime = $row['sale_datetime'];
            $this->number_sales = $row['number_sales'];
        }
    }
}