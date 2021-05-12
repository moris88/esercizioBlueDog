<?php
/**
 * Created by PhpStorm.
 * User: lorenzo
 * Date: 30/01/2018
 * Time: 17:21
 */
class Discography{
    // database connection and table name
    private $conn;
    private $table_name = "discography";

    public $id;
    public $title;
    public $stage_name_id;
    public $language_id;
    public $sales_id;
    public $release_datetime;

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
            $this->title = $row['title'];
            $this->stage_name_id = $row['stage_name_id'];
            $this->language_id = $row['language_id'];
            $this->sales_id = $row['sales_id'];
            $this->release_datetime = $row['release_datetime'];
        }
    }

    function orderByArtist($artist){
        $query = "
        SELECT * FROM ".$this->table_name." 
        LEFT JOIN artist ON ".$this->table_name.".stage_name_id = :artist 
        INNER JOIN sales ON ".$this->table_name.".sales_id = sales.id 
        HAVING ".$this->table_name.".stage_name_id=artist.id 
        ORDER BY sales.number_sales DESC 
        LIMIT 0,3
        ";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":artist", $artist,PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    function orderByYear($year){
        $dateStart = $year."-01-01";
        $dateEnd = $year."-12-31";
        $query = "
        SELECT * FROM ".$this->table_name." 
        INNER JOIN sales ON sales.sale_datetime > :dateStart AND sales.sale_datetime <= :dateEnd 
        INNER JOIN artist ON ".$this->table_name.".stage_name_id=artist.id 
        HAVING ".$this->table_name.".sales_id=sales.id 
        ORDER BY sales.number_sales DESC 
        LIMIT 0,3
        ";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":dateStart", $dateStart,PDO::PARAM_STR);
        $stmt->bindParam(":dateEnd", $dateEnd,PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    function orderByLanguage($lang){

        $query = "
        SELECT * FROM ".$this->table_name." 
        INNER JOIN language ON ".$this->table_name.".language_id = language.id 
        INNER JOIN sales ON ".$this->table_name.".sales_id = sales.id 
        INNER JOIN artist ON ".$this->table_name.".stage_name_id = artist.id 
        HAVING ".$this->table_name.".language_id = :lang 
        ORDER BY sales.number_sales DESC
        LIMIT 0,3;
        ";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":lang", $lang,PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }
}