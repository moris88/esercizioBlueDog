<?php
    include_once '../config/database.php';
    include_once '../objects/artist.php';
    include_once '../objects/discography.php';
    include_once '../objects/language.php';
    include_once '../objects/sales.php';

    /*
    URL SERVER:

    LISTA PER QUERY

    http://localhost/phpchallenge/api/search/ + artist=[nome artista]

    oppure

    http://localhost/phpchallenge/api/search/ + year=[anno discografia]

    oppure

    http://localhost/phpchallenge/api/search/ + lang=[lingua discografia]

    LISTA DI TUTTE LE DISCOGRAFIE

    http://localhost/phpchallenge/api/search/id=0

    oppure

    http://localhost/phpchallenge/api/search/id= + [id della discografia]

    */

    $database = new Database();
    $db = $database->getConnection();
    $array_output=array();

    $action = 0;
    $search = '';
    if(isset($_REQUEST['artist'])){ 
        $search = filter_var($_REQUEST['artist'],FILTER_SANITIZE_STRING);
        $action = 1;
    }else if(isset($_REQUEST['year'])){
        $search = filter_var($_REQUEST['year'],FILTER_SANITIZE_STRING);
        $action = 2;
    }else if(isset($_REQUEST['lang'])){
        $search = filter_var($_REQUEST['lang'],FILTER_SANITIZE_STRING);
        $action = 3;
    }else if(isset($_REQUEST['id'])){
        $search = filter_var($_REQUEST['id'],FILTER_SANITIZE_NUMBER_INT);
        $action = 4;
    }

    switch($action){
        case 1: //ordina per numero di vendite in base all'artista
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            
            $discography = new Discography($db);
            $artist = new Artist($db);
        
            $artist->readOneByName($search);
            $stmt = $discography->orderByArtist($artist->id);
            $num = $stmt->rowCount();
            if($num>0){
                
                $array_output["records"]=array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    
                    $discography_item = array(
                        "id" =>  $row['id'],
                        "title" => $row['title'],
                        "stage_name" => $row['stage_name'],
                        "release_datetime" => $row['release_datetime'],
                        "sales" => $row['number_sales'],
                    );
                    array_push($array_output["records"], $discography_item);
                }
            }
            break;
        case 2: //ordina per numero di vendite in base all'anno
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            
            $discography = new Discography($db);
        
            $stmt = $discography->orderByYear($search);
            $num = $stmt->rowCount();
            if($num>0){
                
                $array_output["records"]=array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    $discography_item = array(
                        "id" =>  $row['id'],
                        "title" => $row['title'],
                        "stage_name" => $row['stage_name'],
                        "release_datetime" => $row['release_datetime'],
                        "sales" => $row['number_sales'],
                    );
                    array_push($array_output["records"], $discography_item);
                }
            }
            break;
        case 3: //ordina per numero di vendite in base alla lingua
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            
            $discography = new Discography($db);
            $language = new Language($db);
        
            $language->readLanguage($search);
            $stmt = $discography->orderByLanguage($language->id);
            $num = $stmt->rowCount();
            if($num>0){
                
                $array_output["records"]=array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    $discography_item = array(
                        "id" =>  $row['id'],
                        "title" => $row['title'],
                        "stage_name" => $row['stage_name'],
                        "language" => $row['language'],
                        "release_datetime" => $row['release_datetime'],
                        "sales" => $row['number_sales'],
                    );
                    array_push($array_output["records"], $discography_item);
                }
            }
            break;
        case 4:
            $id = $search; 
            if($id>0){
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                
                $discography = new Discography($db);
                $artist = new Artist($db);
                $sales = new Sales($db);
                $lang = new Language($db);
            
                $discography->readOne($id);
                $artist->readOne($discography->stage_name_id);
                $sales->readOne($discography->sales_id);
                $lang->readOne($discography->language_id);
                $array_output["records"]=array();
                $discography_item = array(
                    "id" =>  $discography->id,
                    "title" => $discography->title,
                    "stage_name" => $artist->stage_name,
                    "language" => $lang->language,
                    "sales" => $sales->number_sales,
                    "release_datetime" => $sales->sale_datetime
                );
                array_push($array_output["records"], $discography_item);

            }else{
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");

                $discography = new Discography($db);
                $artist = new Artist($db);
                $sales = new Sales($db);
                $lang = new Language($db);
                $stmt = $discography->readAll();
                $num = $stmt->rowCount();
                if($num>0){

                    $array_output["records"]=array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
    
                        $artist->readOne($row['stage_name_id']);
                        $sales->readOne($row['sales_id']);
                        $lang->readOne($row['language_id']);
                        $discography_item = array(
                            "id" =>  $row['id'],
                            "title" => $row['title'],
                            "stage_name" => $artist->stage_name,
                            "language" => $lang->language,
                            "sales" => $sales->number_sales,
                            "release_datetime" => $sales->sale_datetime
                        );
                        array_push($array_output["records"], $discography_item);
                    }
                }
            }
            break;
        case 0:
            echo 'error url';
            break;
    }

    //RESPONSE
    if(array_key_exists('records',$array_output)){
        print_r(json_encode($array_output));
    }else{
        echo json_encode(
            array("message" => "No discography found.")
        );
    }