<?php 
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    //header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
  
    //include connection
    include_once 'connection.php';

    //get information from user to login
    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
        $new_sale = "INSERT INTO sales (sale, idUser) VALUES (:sale, :idUser)";
        $set_sale = $conn->prepare($new_sale);

        $set_sale->bindParam(':sale', $data['sale']);
        $set_sale->bindParam(':idUser', $data['idUser']);
        $set_sale->execute();

        $response = [
            "erro" => false,
            "Message" => "sale registered successfully",
        ];
       

    } else {
        $response = [
            "erro" => true,
            "Message" => "information invalid",
        ];
    }

    http_response_code(200);
    echo json_encode($response);

?>